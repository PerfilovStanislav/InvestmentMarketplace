<?php

namespace Services;

use DiDom\Document;
use Mappers\HyiplogsMapper;
use Models\Constant\PlanPeriodType;
use Traits\Instance;

class HyiplogsService
{
    use Instance;

    private Document $document;

    public function setUrl(string $url): self {
        $this->document = new Document(sprintf('https://hyiplogs.com/project/%s', $url), true);
        return $this;
    }

    public function getPayments(): array {
        $str = $this->document->first('div.container-fluid div.info-box div.item:nth-child(6) div.txt')->text();
        $str = explode(',', trim($str));
        return (new HyiplogsMapper())->payments($str);
    }

    public function getRating() {
        return $this->document->first('div.container-fluid div.hl-index-box span')->text();
    }

    public function getPlans() {
        try {
            $str = $this->document->first('.content div.info-box div.item:nth-child(1) div.txt')->text();
        } catch (\Throwable $e) {
            return [];
        }

        $result = [];
        $strPlans = explode(';', strtolower($str));
        foreach ($strPlans as $strPlan) {
            $strPlan = preg_replace('/\(.*?\)/', '', $strPlan); // убираем скобки
            $strPlan = str_replace('up to ', '', $strPlan);
            $strPlan = trim($strPlan);
            $strPlan = str_replace(['forever', 'for lifetime'], ' for 1 ___', $strPlan);

            if (strpos($strPlan, 'roi') !== false) {
                continue;
            }

            // 1.25% - 2.1% daily for 20 - 60 days
            // 1.2% - 10.3% daily for 15 - 30 business days
            if (preg_match('/^([0-9.]+)% ?- ?([0-9.]+)% ?(\w+) ?for ?(\d+) ?- ?(\d+) ?(\w+ )?(\w+)$/', $strPlan, $v)) {
                if ($v[7] === '___') {
                    $v[7] = PlanPeriodType::getConstNameLower($this->getPlanPeriodType($v[3]));
                }
                $coefficient = $this->calculateCoefficientForPeriodTypes(
                        $this->getPlanPeriodType($v[3]),
                        $this->getPlanPeriodType($v[7]),
                    ) * $this->businessCoefficient($v[6]);
                $result[] = [
                    $this->round($v[1] * $coefficient * $v[4]),
                    $v[4],
                    $this->getPlanPeriodType($v[7]),
                ];
                $result[] = [
                    $this->round($v[2] * $coefficient * $v[5]),
                    $v[5],
                    $this->getPlanPeriodType($v[7]),
                ];
                continue;
            }

            // 3% - 5% business daily for 150% profit
            // 3% - 5% daily for 150% profit
            if (preg_match('/^([0-9.]+)% ?- ?([0-9.]+)% ?( ?\w*) (\w+) \w+ (\d+)% profit$/', $strPlan, $v)) {
                $percent = ($v[1] + $v[2]) * 0.5 * $this->businessCoefficient($v[3]);
                $period = round(($v[5] / $percent), 0, PHP_ROUND_HALF_UP);
                $result[] = [
                    $this->round($percent * $period),
                    $period,
                    $this->getPlanPeriodType($v[4]),
                ];
                continue;
            }

            // 415% after 51 business days
            // 415% after 51 days
            if (preg_match('/^([0-9.]+)% ?after ?(\d+) ?(\w+ )?(\w+)$/', $strPlan, $v)) {
                $result[] = [
                    $this->round($v[1] * $this->businessCoefficient($v[3])),
                    $v[2],
                    $this->getPlanPeriodType($v[4]),
                ];
                continue;
            }

            // 102% - 111% after 1 day
            // 150%- 190% after 3 business days
            if (preg_match('/^([0-9.]+)% ?- ?([0-9.]+)% ?after ?(\d+) ?(\w+ )?(\w+)$/', $strPlan, $v)) {
                $result[] = [
                    $this->round(($v[1] + $v[2]) * 0.5 * $this->businessCoefficient($v[4])),
                    $v[3],
                    $this->getPlanPeriodType($v[5]),
                ];
                continue;
            }

            // 55% - 70% daily for 2 days
            // 2% - 3% hourly for 3 days
            // 2.5% - 3.1% hourly for 3 business days
            if (preg_match('/^([0-9.]+)% ?- ?([0-9.]+)% ?(\w+) *(\w+) ?(\d+) ?(\w+ )?(\w+)$/', $strPlan, $v)) {
                if ($v[7] === '___') {
                    $v[7] = PlanPeriodType::getConstNameLower($this->getPlanPeriodType($v[3]));
                }
                $coefficient = $this->calculateCoefficientForPeriodTypes(
                        $this->getPlanPeriodType($v[3]),
                        $this->getPlanPeriodType($v[7]),
                    ) * $this->businessCoefficient($v[6]);
                $result[] = [
                    $this->round(($v[1] + $v[2]) * 0.5 * $coefficient * $v[5]),
                    $v[5],
                    $this->getPlanPeriodType($v[7]),
                ];
                continue;
            }
            // 0.33% - 0.63% daily
            // 0.33% - 0.63% hourly
            if (preg_match('/^([0-9.]+)% ?- ?([0-9.]+)% ?(\w+)$/', $strPlan, $v)) {
                $result[] = [
                    $this->round(($v[1] + $v[2]) * 0.5),
                    1,
                    $this->getPlanPeriodType($v[3]),
                ];
                continue;
            }

            // up to 4% daily
            // up to 4% hourly
            if (preg_match('/^([0-9.]+)% ?(\w+)$/', $strPlan, $v)) {
                $result[] = [
                    $this->round($v[1]),
                    1,
                    $this->getPlanPeriodType($v[2]),
                ];
                continue;
            }

            // 1.8% daily for 100 days
            // 2.5% hourly for 80 business days
            if (preg_match('/^([0-9.]+)% ?(\w+) *(\w+) ?(\d+) ?(\w+ )?(\w+)$/', $strPlan, $v)) {
                $coefficient = $this->calculateCoefficientForPeriodTypes(
                        $this->getPlanPeriodType($v[2]),
                        $this->getPlanPeriodType($v[6]),
                    ) * $this->businessCoefficient($v[5]);
                $result[] = [
                    $this->round($v[1] * $coefficient * $v[4]),
                    $v[4],
                    $this->getPlanPeriodType($v[6]),
                ];
                continue;
            }
        }

        return $result;
    }

    private function round(float $percent): float {
        return round($percent, 2, PHP_ROUND_HALF_DOWN);
    }

    private function businessCoefficient(string $str): float {
        return strpos($str, 'business') !== false ? 5/7 : 1.0;
    }

    private function calculateCoefficientForPeriodTypes(int $timely, int $periodType, float $coefficient = 1.0): float {
        if ($timely === $periodType) {
            return $coefficient;
        }
        if ($timely < $periodType) {
            $coefficient *= [
                    PlanPeriodType::YEAR  => 12,             // 1 year = 12 months
                    PlanPeriodType::MONTH => 4.34821428571,  // 1 month = 4,34821428571 weeks
                    PlanPeriodType::WEEK  => 7,              // 1 week = 7 days
                    PlanPeriodType::DAY   => 24,             // 1 day = 24 hours
                    PlanPeriodType::HOUR  => 60,             // 1 hour = 60 minutes
                ][++$timely] ?? 0;

            return $this->calculateCoefficientForPeriodTypes($timely, $periodType, $coefficient);
        }

        return 0;
    }

    private function getPlanPeriodType(string $periodTypeStr): int {
        foreach (PlanPeriodType::getConstNames() as $constName) {
            if (stripos($periodTypeStr, $constName) !== false) {
                return PlanPeriodType::getValue($constName);
            }
        }
        if (stripos($periodTypeStr, 'daily') !== false) {
            return PlanPeriodType::DAY;
        }
        return 0;
    }

}