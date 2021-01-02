<?php

namespace Services;

use DiDom\Document;
use Exceptions\ErrorException;
use Helpers\HttpClient\CurlHttpClient;
use Helpers\HttpClient\CurlRequestDto;
use Helpers\HttpClient\CurlResponseDto;
use Helpers\Validator;
use Models\Constant\CurrencyType;
use Models\Constant\Payment;
use Models\Constant\PaymentType;
use Traits\Instance;
use Traits\UrlValidate;

class HyipboxService {
    use Instance, UrlValidate;

    const PREFIX = 'https://hyipbox.org/details/';

    private Document $document;

    public function setUrl(string $url): self {
        $url = self::PREFIX . $url;

        $client = (new CurlHttpClient());
        $request = new CurlRequestDto($url);
        $result = $this->reTry(static function() use ($client, $request) {
            return $client->get($request);
        });

        $options = 	[
            "indent" => false,
            "output-xml" => false,
            "clean" => true,
            "drop-proprietary-attributes" => true,
            "drop-empty-paras" => true,
            "hide-comments" => true,
            "join-classes" => true,
            "join-styles" => true,
            "show-body-only" => true,
        ];
        $tidy = new \tidy();
        $tidy->parseString($result->getRawBody(), $options, 'utf8');
        $tidy->cleanRepair();

        $this->document = new Document($tidy->html()->value, false);
        return $this;
    }

    /** @return CurlResponseDto */
    private function reTry(callable $functionForCall, int $try = 1)
    {
        $result = $functionForCall();
        if ($result->getError() !== '') {
            if ($try === 1) {
                throw new ErrorException(__CLASS__, $result->getError());
            }
            sleep($try * 5);
            return $this->reTry($functionForCall, ++$try);
        }
        return $result;
    }

    public function isScam(): bool {
//        try {
            return (bool)$this->document->first('div.block_coun_st div.st_scam');
//        } catch (\Throwable $e) {
//            return false;
//        }
    }

    public function getTitle(): ?string {
        try {
            return ucfirst($this->document->first('div.h_name a')->text());
        } catch (\Throwable $e) {
            return null;
        }
    }

    public function getStartDate(): int {
        try {
            return strtotime(trim($this->document->first('div.h_st_date div:nth-child(2)')->text()));
        } catch (\Throwable $e) {
            return 0;
        }
    }

    public function getPaymentTypeId(): int {
        try {
            $paymentType = strtolower($this->document->find('div.feat_elm')[10]->first('div.body_feat_elem')->text()) ?? '';

            if (strpos($paymentType, 'manual') !== false) {
                return PaymentType::MANUAL;
            }
            if (strpos($paymentType, 'instant') !== false) {
                return PaymentType::INSTANT;
            }
            if (strpos($paymentType, 'automatic') !== false) {
                return PaymentType::AUTOMATIC;
            }
        } catch (\Throwable $e) {
        }

        return PaymentType::AUTOMATIC;
    }

    public function getMinDeposit(): array {
        if ($dom = ($this->document->find('div.feat_elm')[9] ?? null)) {
            try {
                $str = $dom->first('div.body_feat_elem')->text();
                $value = preg_replace('/[^' . Validator::FLOAT . ']/', '', $str);
                return ['deposit' => $value, 'currency' => $this->getCurrencyType($str)];
            } catch (\Throwable $e) {
                return [];
            }
        }
        return [];
    }

    public function getReferralPlans(): array {
        $strPlan = trim($this->document->find('div.feat_elm')[9]->find('div.body_feat_elem')[2]->text()) ?? '';
        $strPlan = preg_replace('/[^'.Validator::FLOAT.'\-,]/', '', $strPlan);
        $strPlan = str_replace([','], ['-'], $strPlan);
        return array_filter(explode('-', $strPlan), fn($plan) => $plan > 0);
    }

    public function getPayments(): array {
        $str = $this->document->find('div.feat_elm')[11]->first('div.body_feat_elem')->innerHtml() ?? '';
        preg_match_all('/<div .*?(\d+)\.png.*?<\/div>/', $str, $matches);
        return array_values(array_filter(array_map([$this, 'getPayment'], $matches[1])));
    }

    public function getDescription(): string {
        return trim($this->document->find('div.feat_elm')[12]->first('div.body_feat_elem')->text()) ?? '';
    }

    private function getCurrencyType(string $str): int {
        foreach (CurrencyType::getConstNames() as $constName) {
            if (stripos($str, $constName) !== false) {
                return CurrencyType::getValue($constName);
            }
        }
        foreach (CurrencyType::$symbols as $currency => $symbol) {
            if (stripos($str, $symbol) !== false) {
                return $currency;
            }
        }
        return CurrencyType::USD;
    }

    private function getPayment(int $payment): int {
        return [
            2  => Payment::PERFECTMONEY,
            3  => Payment::PAYEER,
            4  => Payment::ADVCASH,
            5  => Payment::BITCOIN,
            6  => Payment::LITECOIN,
            7  => Payment::PAYZA,
            8  => Payment::OKPAY,
            9  => 0, // don't know
            11 => Payment::ETHEREUM,
            12 => Payment::BITCOINCASH,
            13 => Payment::DASHCOIN,
            14 => Payment::DOGECOIN,
            15 => 0, // Банк
            16 => 0, // Ripple
        ][$payment] ?? 0;
    }
}