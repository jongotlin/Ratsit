<?php

declare(strict_types=1);

namespace JGI\Ratsit;

use Http\Client\HttpClient;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Message\RequestFactory;
use JGI\Ratsit\Event\PersonInformationResultEvent;
use JGI\Ratsit\Event\PersonSearchResultEvent;
use JGI\Ratsit\Model\SearchResult;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class Ratsit
{
    /**
     * @var HttpClient
     */
    private $httpClient;

    /**
     * @var RequestFactory
     */
    private $messageFactory;

    /**
     * @var array
     */
    private $options = [];

    /**
     * @var Denormalizer
     */
    private $denormalizer;

    /**
     * @var EventDispatcherInterface|null
     */
    private $eventDispatcher;

    /**
     * @var array
     */
    private static $defaultOptions = [
        'url' => 'https://api.ratsit.se/api/v1/',
        'token' => '',
    ];

    /**
     * @param string $token
     * @param array $options
     */
    public function __construct(string $token, array $options = [])
    {
        $options['token'] = $token;
        $this->setOptions($options);
    }

    /**
     * @param HttpClient $httpClient
     */
    public function setHttpClient(HttpClient $httpClient): void
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param null|EventDispatcherInterface $eventDispatcher
     */
    public function setEventDispatcher(?EventDispatcherInterface $eventDispatcher): void
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param array $options
     */
    private function setOptions(array $options)
    {
        $this->options = self::$defaultOptions;
        $this->options = array_merge($this->options, $options);
    }

    /**
     * @return RequestFactory
     */
    private function getMessageFactory()
    {
        if (!$this->messageFactory) {
            $this->messageFactory = MessageFactoryDiscovery::find();
        }

        return $this->messageFactory;
    }

    /**
     * @return Denormalizer
     */
    private function getDenormalizer()
    {
        if (!$this->denormalizer) {
            $this->denormalizer = new Denormalizer();
        }

        return $this->denormalizer;
    }

    /**
     * @param string $method
     * @param string $package
     * @param array $parameters
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Exception
     * @throws \Http\Client\Exception
     */
    private function request(string $method, string $package, array $parameters = [])
    {
        $request = call_user_func_array(
            [$this, 'buildRequestInstance'],
            [$method, $package, $parameters]
        );

        return $this->httpClient->sendRequest($request);
    }

    /**
     * @param string $method
     * @param string $package
     * @param array $parameters
     *
     * @return \Psr\Http\Message\RequestInterface
     */
    public function buildRequestInstance(string $method, string $package, array $parameters)
    {
        $uri = $this->options['url'] . $method . '?' . http_build_query($parameters);
        return $this->getMessageFactory()->createRequest('GET', $uri, [
            'Authorization' => sprintf('Basic %s', $this->options['token']),
            'package' => $package,
        ]);
    }

    /**
     * @param string|null $ssn
     *
     * @return Model\Person
     */
    public function findPersonBySocialSecurityNumber(?string $ssn)
    {
        $json = $this->request('personinformation', 'personinformation', ['ssn' => $ssn])->getBody()->getContents();

        $person = $this->getDenormalizer()->denormalizerPersonInformation(json_decode($json, true));

        if ($this->eventDispatcher) {
            $this->eventDispatcher->dispatch(
                PersonInformationResultEvent::NAME, new PersonInformationResultEvent($person)
            );
        }

        return $person;
    }

    /**
     * @param null|string $who
     * @param null|string $where
     *
     * @return Model\Person[]|SearchResult
     */
    public function searchPerson(?string $who, ?string $where = null)
    {
        $json = $this->request('personsearch', 'personsok', ['who' => $who, 'where' => $where])->getBody()->getContents();

        $searchResult = $this->getDenormalizer()->denormalizerPersonSearch(json_decode($json, true));

        if ($this->eventDispatcher) {
            $this->eventDispatcher->dispatch(
                PersonSearchResultEvent::NAME, new PersonSearchResultEvent($searchResult)
            );
        }

        return $searchResult;
    }
}
