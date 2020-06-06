<?php

namespace Services;

use DiDom\Document;
use Helpers\Validator;
use Models\Constant\CurrencyType;
use Models\Constant\Payment;
use Models\Constant\PaymentType;
use Models\Constant\PlanPeriodType;

class HyipboxService
{
    private string $url;
    private Document $document;

    public function __construct(string $url) {
        $this->url = sprintf('https://hyipbox.org/details/%s', $url);
    }

    private function getDocument(): Document {
        return $this->document ??= new Document($this->url, true);
    }

    public function isScam(): bool {
        return (bool)$this->getDocument()->first('div.block_coun_st div.st_scam');
    }

    public function getTitle(): ?string {
        return $this->getDocument()->first('div.h_name a')->text() ?? null;
    }

    public function getStartDate(): int {
        return strtotime(trim($this->getDocument()->first('div.h_st_date div:nth-child(2)')->text())) ?? 0;
    }

    public function getPaymentTypeId(): int {
        $paymentType = strtolower($this->getDocument()->find('div.feat_elm')[10]->first('div.body_feat_elem')->text()) ?? '';

        if (strpos($paymentType, 'manual') !== false) {
            return PaymentType::MANUAL;
        }
        if (strpos($paymentType, 'instant') !== false) {
            return PaymentType::INSTANT;
        }
        if (strpos($paymentType, 'automatic') !== false) {
            return PaymentType::AUTOMATIC;
        }

        return 0;
    }

    public function getPlans(array $currency): array {
        $strPlans = explode(', ', strtolower(trim($this->getDocument()->find('div.feat_elm')[8]->first('div.body_feat_elem')->text())) ?? '');
        $plans = [];
        foreach ($strPlans as $key => $strPlan) {
            preg_match('/([0-9.]+)%.*?(\d+) (\w+)/', $strPlan, $matches);
            if ($matches) {
                $plans[$key][] = $matches[1];
                $plans[$key][] = $matches[2];
                $plans[$key][] = $this->getPlanPeriodType($matches[3]);
                $plans[$key][] = $currency['value'];
                $plans[$key][] = $currency['type'];
                continue;
            }

            preg_match('/([0-9.]+).*?% [per]* (\w+)$/', $strPlan, $matches);
            if ($matches) {
                $plans[$key][] = $matches[1];
                $plans[$key][] = 1;
                $plans[$key][] = $this->getPlanPeriodType($matches[2]);
                $plans[$key][] = $currency['value'];
                $plans[$key][] = $currency['type'];
                continue;
            }

            preg_match('/([0-9.]+).*?%/', $strPlan, $matches);
            if ($matches) {
                $plans[$key][] = $matches[1];
                $plans[$key][] = 1;
                $plans[$key][] = PlanPeriodType::DAY;
                $plans[$key][] = $currency['value'];
                $plans[$key][] = $currency['type'];
                continue;
            }
        }

        return $plans;
    }

    public function getMinDeposit(): array {
        $str = $this->getDocument()->find('div.feat_elm')[9]->first('div.body_feat_elem')->text();
        $value = preg_replace('/[^'.Validator::FLOAT.']/', '', $str);
        $type = strtolower(trim(preg_replace('/[0-9.]/', '', $str)));
        return ['value' => $value, 'type' => $this->getCurrencyType($type)];
    }

    public function getReferralPlans(): array {
        $strPlan = trim($this->getDocument()->find('div.feat_elm')[9]->find('div.body_feat_elem')[2]->text()) ?? '';
        $strPlan = preg_replace('/[^'.Validator::FLOAT.'\-]/', '', $strPlan);
        return explode('-', $strPlan);
    }

    public function getPayments(): array {
        $str = $this->getDocument()->find('div.feat_elm')[11]->first('div.body_feat_elem')->innerHtml() ?? '';
        preg_match_all('/<div .*?(\d+)\.png.*?<\/div>/', $str, $matches);
        return array_values(array_filter(array_map([$this, 'getPayment'], $matches[1])));
    }

    public function getDescription(): string {
        return trim($this->getDocument()->find('div.feat_elm')[12]->first('div.body_feat_elem')->text()) ?? '';
    }

    private function getCurrencyType(string $type): int {
        return [
            '$' => CurrencyType::USD,
            'btc' => CurrencyType::BTC,
        ][$type] ?? CurrencyType::getValue($type) ?? CurrencyType::USD;
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

    private function getPlanPeriodType(string $periodTypeStr): int {
        switch ($periodTypeStr) {
            case 'minute':
            case 'minutes':
                return PlanPeriodType::MINUTE;
            case 'hour':
            case 'hours':
                return PlanPeriodType::HOUR;
            case 'day':
            case 'days':
                return PlanPeriodType::DAY;
            case 'week':
            case 'weeks':
                return PlanPeriodType::WEEK;
            case 'month':
            case 'months':
                return PlanPeriodType::MONTH;
            case 'year':
            case 'years':
                return PlanPeriodType::YEAR;
            default:
                return 0;
        }
    }
}