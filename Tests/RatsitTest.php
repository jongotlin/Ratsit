<?php

declare(strict_types=1);

namespace JGI\Ratsit\Tests;

use JGI\Ratsit\Denormalizer;
use JGI\Ratsit\Model\Address;
use JGI\Ratsit\Model\Person;
use JGI\Ratsit\Model\SearchResult;
use JGI\Ratsit\Ratsit;
use PHPUnit\Framework\TestCase;
use Http\Client\HttpClient;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class RatsitTest extends TestCase
{
    /**
     * @test
     */
    public function shouldFindPersonBySocialSecurityNumber()
    {
        $ratsit = new Ratsit('foo');
        $clientMock = $this->getClient(file_get_contents(__DIR__ . '/personInformation.json'));
        $eventDispatcherMock = $this->getMockBuilder(EventDispatcherInterface::class)->getMock();
        $eventDispatcherMock->expects($this->once())->method('dispatch');
        $ratsit->setEventDispatcher($eventDispatcherMock);
        $ratsit->setHttpClient($clientMock);

        $ratsit->findPersonBySocialSecurityNumber('000');
    }

    /**
     * @test
     */
    public function shouldSearchPerson()
    {
        $ratsit = new Ratsit('foo');
        $clientMock = $this->getClient(file_get_contents(__DIR__ . '/personSearch.json'));
        $eventDispatcherMock = $this->getMockBuilder(EventDispatcherInterface::class)->getMock();
        $eventDispatcherMock->expects($this->once())->method('dispatch');
        $ratsit->setEventDispatcher($eventDispatcherMock);
        $ratsit->setHttpClient($clientMock);

        $ratsit->searchPerson('foo');
    }

    /**
     * @test
     */
    public function shouldFindCompanyByOrganisationNumber()
    {
        $ratsit = new Ratsit('foo');
        $clientMock = $this->getClient(file_get_contents(__DIR__ . '/companyInformation.json'));
        $eventDispatcherMock = $this->getMockBuilder(EventDispatcherInterface::class)->getMock();
        $eventDispatcherMock->expects($this->once())->method('dispatch');
        $ratsit->setEventDispatcher($eventDispatcherMock);
        $ratsit->setHttpClient($clientMock);

        $ratsit->findCompanyByOrganisationNumber('000');
    }

    /**
     * @param string|null $json
     *
     * @return \PHPUnit\Framework\MockObject\MockObject|HttpClient
     */
    private function getClient(?string $json)
    {
        $httpClientMock = $this->getMockBuilder(HttpClient::class)->getMock();
        $responseMock = $this->getMockBuilder(ResponseInterface::class)->getMock();
        $streamMock = $this->getMockBuilder(StreamInterface::class)->getMock();
        $streamMock->method('getContents')->willReturn($json);
        $responseMock->method('getBody')->willReturn($streamMock);
        $httpClientMock->method('sendRequest')->willReturn($responseMock);

        return $httpClientMock;
    }
}
