<?php

namespace Eureka;

use Eureka\Discovery\RandomStrategy;
use Eureka\Interfaces\DiscoveryStrategy;
use Eureka\Interfaces\InstanceProvider;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

class EurekaConfig
{

    private string $eurekaDefaultUrl = 'http://localhost:8761';
    private string $hostName;
    private string $appName;
    private mixed  $ip;
    private string $status           = 'UP';
    private string $overriddenStatus = 'UNKNOWN';
    private mixed  $port;
    private array  $securePort       = ['443', false];
    private string $countryId        = '1';
    private array  $dataCenterInfo   = ['com.netflix.appinfo.InstanceInfo$DefaultDataCenterInfo', 'MyOwn' /* keyword */];
    private string $homePageUrl;
    private string $statusPageUrl;
    private string $healthCheckUrl;
    private string $vipAddress;
    private string $secureVipAddress;

    private int $heartbeatInterval = 30;

    /**
     * @var DiscoveryStrategy
     */
    private DiscoveryStrategy $discoveryStrategy;

    /**
     * @var InstanceProvider
     */
    private InstanceProvider $instanceProvider;

    // constructor
    #[Pure]
    public function __construct($config)
    {
        foreach ($config as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }

        // defaults
        if (empty($this->hostName)) {
            $this->hostName = $this->ip;
        }
        if (empty($this->vipAddress)) {
            $this->vipAddress = $this->appName;
        }
        if (empty($this->secureVipAddress)) {
            $this->secureVipAddress = $this->appName;
        }
        if (empty($this->discoveryStrategy)) {
            $this->discoveryStrategy = new RandomStrategy();
        }
    }

    // getters
    public function getEurekaDefaultUrl(): string
    {
        return $this->eurekaDefaultUrl;
    }

    public function getHostName()
    {
        return $this->hostName;
    }

    public function getAppName(): string
    {
        return $this->appName;
    }

    public function getIp()
    {
        return $this->ip;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getOverriddenStatus(): string
    {
        return $this->overriddenStatus;
    }

    public function getPort()
    {
        return $this->port;
    }

    public function getSecurePort(): array
    {
        return $this->securePort;
    }

    public function getCountryId(): string
    {
        return $this->countryId;
    }

    public function getDataCenterInfo(): array
    {
        return $this->dataCenterInfo;
    }

    public function getHomePageUrl(): string
    {
        return $this->homePageUrl;
    }

    public function getStatusPageUrl(): string
    {
        return $this->statusPageUrl;
    }

    public function getHealthCheckUrl(): string
    {
        return $this->healthCheckUrl;
    }

    public function getVipAddress(): string
    {
        return $this->vipAddress;
    }

    public function getSecureVipAddress(): string
    {
        return $this->secureVipAddress;
    }

    public function getHeartbeatInterval(): int
    {
        return $this->heartbeatInterval;
    }

    public function getDiscoveryStrategy(): DiscoveryStrategy|RandomStrategy
    {
        return $this->discoveryStrategy;
    }

    public function getInstanceProvider(): InstanceProvider
    {
        return $this->instanceProvider;
    }

    // setters
    public function setEurekaDefaultUrl($eurekaDefaultUrl)
    {
        $this->eurekaDefaultUrl = $eurekaDefaultUrl;
    }

    public function setHostName($hostName)
    {
        $this->hostName = $hostName;
    }

    public function setAppName($appName)
    {
        $this->appName = $appName;
    }

    public function setIp($ip)
    {
        $this->ip = $ip;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function setOverriddenStatus($overriddenStatus)
    {
        $this->overriddenStatus = $overriddenStatus;
    }

    public function setPort($port)
    {
        $this->port = $port;
    }

    public function setSecurePort($securePort)
    {
        $this->securePort = $securePort;
    }

    public function setCountryId($countryId)
    {
        $this->countryId = $countryId;
    }

    public function setDataCenterInfo($dataCenterInfo)
    {
        $this->dataCenterInfo = $dataCenterInfo;
    }

    public function setHomePageUrl($homePageUrl)
    {
        $this->homePageUrl = $homePageUrl;
    }

    public function setStatusPageUrl($statusPageUrl)
    {
        $this->statusPageUrl = $statusPageUrl;
    }

    public function setHealthCheckUrl($healthCheckUrl)
    {
        $this->healthCheckUrl = $healthCheckUrl;
    }

    public function setVipAddress($vipAddress)
    {
        $this->vipAddress = $vipAddress;
    }

    public function setSecureVipAddress($secureVipAddress)
    {
        $this->secureVipAddress = $secureVipAddress;
    }

    public function setHeartbeatInterval($heartbeatInterval)
    {
        $this->heartbeatInterval = $heartbeatInterval;
    }

    public function setDiscoveryStrategy(DiscoveryStrategy $discoveryStrategy)
    {
        $this->discoveryStrategy = $discoveryStrategy;
    }

    public function setInstanceProvider(InstanceProvider $instanceProvider)
    {
        $this->instanceProvider = $instanceProvider;
    }

    //
    #[ArrayShape(['instance' => "array"])]
    public function getRegistrationConfig(): array
    {
        return [
            'instance' => [
                'instanceId'       => $this->getInstanceId(),
                'hostName'         => $this->hostName,
                'app'              => $this->appName,
                'ipAddr'           => $this->ip,
                'status'           => $this->status,
                'overriddenstatus' => $this->overriddenStatus,
                'port'             => [
                    '$'        => $this->port[0],
                    '@enabled' => $this->port[1]
                ],
                'securePort'       => [
                    '$'        => $this->securePort[0],
                    '@enabled' => $this->securePort[1]
                ],
                'countryId'        => $this->countryId,
                'dataCenterInfo'   => [
                    '@class' => $this->dataCenterInfo[0],
                    'name'   => $this->dataCenterInfo[1]
                ],
                'homePageUrl'      => $this->homePageUrl,
                'statusPageUrl'    => $this->statusPageUrl,
                'healthCheckUrl'   => $this->healthCheckUrl,
                'vipAddress'       => $this->vipAddress,
                'secureVipAddress' => $this->secureVipAddress
            ]
        ];
    }

    public function getInstanceId(): string
    {
        return $this->hostName . ':' . $this->appName . ':' . $this->port[0];
    }

}
