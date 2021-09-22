<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\HttpClient;

use Http\Client\Common\HttpMethodsClient;
use Http\Client\Common\HttpMethodsClientInterface;
use Http\Client\Common\Plugin;
use Http\Client\Common\Plugin\Cache\Generator\HeaderCacheKeyGenerator;
use Http\Client\Common\Plugin\CachePlugin;
use Http\Client\Common\PluginClientFactory;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

final class Builder
{
    private ClientInterface $httpClient;

    private RequestFactoryInterface $requestFactory;

    private StreamFactoryInterface $streamFactory;

    private array $plugins = [];

    private ?CachePlugin $cachePlugin = null;

    private ?HttpMethodsClientInterface $pluginClient = null;

    public function __construct(
        ClientInterface $httpClient = null,
        RequestFactoryInterface $requestFactory = null,
        StreamFactoryInterface $streamFactory = null
    ) {
        $this->httpClient = $httpClient ?? Psr18ClientDiscovery::find();
        $this->requestFactory = $requestFactory ?? Psr17FactoryDiscovery::findRequestFactory();
        $this->streamFactory = $streamFactory ?? Psr17FactoryDiscovery::findStreamFactory();
    }

    public function getHttpClient(): HttpMethodsClientInterface
    {
        if (null === $this->pluginClient) {
            $plugins = $this->plugins;
            if (null !== $this->cachePlugin) {
                $plugins[] = $this->cachePlugin;
            }

            $this->pluginClient = new HttpMethodsClient(
                (new PluginClientFactory())->createClient($this->httpClient, $plugins),
                $this->requestFactory,
                $this->streamFactory
            );
        }

        return $this->pluginClient;
    }

    public function addPlugin(Plugin $plugin): void
    {
        $this->plugins[] = $plugin;
        $this->pluginClient = null;
    }

    public function removePlugin(string $fqcn): void
    {
        foreach ($this->plugins as $idx => $plugin) {
            if ($plugin instanceof $fqcn) {
                unset($this->plugins[$idx]);
                $this->pluginClient = null;
            }
        }
    }

    public function addCache(CacheItemPoolInterface $cachePool, array $config = []): void
    {
        $headerTypes = ['Authorization', 'Cookie', 'Accept', 'Content-type'];
        
        if (!isset($config['cache_key_generator'])) {
            $config['cache_key_generator'] = new HeaderCacheKeyGenerator($headerTypes);
        }

        $this->cachePlugin = CachePlugin::clientCache($cachePool, $this->streamFactory, $config);
        $this->pluginClient = null;
    }

    public function removeCache(): void
    {
        $this->cachePlugin = null;
        $this->pluginClient = null;
    }
    
    public function getRequestFactory(): RequestFactoryInterface
    {
        
        return $this->requestFactory;
    }
    
    public function getStreamFactory(): StreamFactoryInterface
    {
        
        return $this->streamFactory;
    }
}
