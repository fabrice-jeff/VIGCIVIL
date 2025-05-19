<?php

namespace App\Tests\Controller;

use App\Entity\Demande;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class DemandeControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $demandeRepository;
    private string $path = '/demande/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->demandeRepository = $this->manager->getRepository(Demande::class);

        foreach ($this->demandeRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Demande index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'demande[reference]' => 'Testing',
            'demande[numeroActe]' => 'Testing',
            'demande[dateSoumission]' => 'Testing',
            'demande[statut]' => 'Testing',
            'demande[copiePdf]' => 'Testing',
            'demande[dateTraitement]' => 'Testing',
            'demande[lieuTraitement]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->demandeRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Demande();
        $fixture->setReference('My Title');
        $fixture->setNumeroActe('My Title');
        $fixture->setDateSoumission('My Title');
        $fixture->setStatut('My Title');
        $fixture->setCopiePdf('My Title');
        $fixture->setDateTraitement('My Title');
        $fixture->setLieuTraitement('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Demande');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Demande();
        $fixture->setReference('Value');
        $fixture->setNumeroActe('Value');
        $fixture->setDateSoumission('Value');
        $fixture->setStatut('Value');
        $fixture->setCopiePdf('Value');
        $fixture->setDateTraitement('Value');
        $fixture->setLieuTraitement('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'demande[reference]' => 'Something New',
            'demande[numeroActe]' => 'Something New',
            'demande[dateSoumission]' => 'Something New',
            'demande[statut]' => 'Something New',
            'demande[copiePdf]' => 'Something New',
            'demande[dateTraitement]' => 'Something New',
            'demande[lieuTraitement]' => 'Something New',
        ]);

        self::assertResponseRedirects('/demande/');

        $fixture = $this->demandeRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getReference());
        self::assertSame('Something New', $fixture[0]->getNumeroActe());
        self::assertSame('Something New', $fixture[0]->getDateSoumission());
        self::assertSame('Something New', $fixture[0]->getStatut());
        self::assertSame('Something New', $fixture[0]->getCopiePdf());
        self::assertSame('Something New', $fixture[0]->getDateTraitement());
        self::assertSame('Something New', $fixture[0]->getLieuTraitement());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Demande();
        $fixture->setReference('Value');
        $fixture->setNumeroActe('Value');
        $fixture->setDateSoumission('Value');
        $fixture->setStatut('Value');
        $fixture->setCopiePdf('Value');
        $fixture->setDateTraitement('Value');
        $fixture->setLieuTraitement('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/demande/');
        self::assertSame(0, $this->demandeRepository->count([]));
    }
}
