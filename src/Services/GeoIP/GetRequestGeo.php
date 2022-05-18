<?php

    namespace Ibrhaim13\Translate\Services\GeoIP;

    use App\Contract\Geo\IGeoIP;
    use App\Contract\Services\IService;
    use App\Services\ParamsTraits\IpAddressTrait;
    use App\Services\ParamsTraits\RequestCookiesTrait;
    use App\Support\Logger;

    class GetRequestGeo implements IGeoIP

    {
        use RequestCookiesTrait;
        use IpAddressTrait;
        private array $urlParams;

        public function exec():IService {

            $utmParams = [];
            foreach($this->requestCookies as $key => $value) {
                if(str_starts_with($key, 'utm_') || $key == 'gclid') {
                    $utmParams[$key] = $value;
                }
            }
            $country      = '';
            $countryCode  = $this->getByUtmMedium($utmParams['utm_medium'] ?? null, $country);
            $ipAddress    = $this->ipAddress;
            list($countryCode, $country) = $this->InspectCountryCode($countryCode, $ipAddress);

            $this->urlParams['ip_address']   = $ipAddress;
            $this->urlParams['country_code'] = strtoupper($countryCode);
            $this->urlParams['country']      = $country;
            return $this;
        }

        private function getByUtmMedium($utmMedium, &$country) {
            if (!empty($utmMedium)) {
                if (strtoupper($utmMedium) === 'DEMO') return $utmMedium;
                $parts = explode('-', $utmMedium);
                if (strlen($parts[0]) == 2) {
                    return strtoupper($parts[0]);
                }
            }
            return null;
        }

        /**
         * @param string|null $countryCode
         * @param array|null $ipAddress
         * @return array
         */
        private function InspectCountryCode(?string $countryCode, ?string $ipAddress): array
        {
            $country = '';
            if (!$countryCode) {
                try {
                    $record = geoip()->getLocation($ipAddress);
                    $countryCode = $record->getAttribute('iso_code');
                    $country = $record->getAttribute('country');
                } catch (\Throwable $e) {
                 //   Logger::debug($e);
                    $countryCode = '';
                }
            }
            return array($countryCode, $country);
        }

        public function setParams(array $params): IService
        {
            $this->urlParams = $params;
            return $this;
        }

        public function getExecOutputs(): array
        {
            return   $this->urlParams;
        }

        public function getExecOutput(string $key)
        {
            return $this->urlParams[$key]??null;
        }

        public function assertOutputExists(string $output, string $message): IService
        {

        }
    }
