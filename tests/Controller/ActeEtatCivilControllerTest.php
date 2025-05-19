<?php

namespace App\Tests\Controller;

use App\Entity\ActeEtatCivil;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class ActeEtatCivilControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $acteEtatCivilRepository;
    private string $path = '/acte/etat/civil/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->acteEtatCivilRepository = $this->manager->getRepository(ActeEtatCivil::class);

        foreach ($this->acteEtatCivilRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('ActeEtatCivil index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'acte_etat_civil[numeroActe]' => 'Testing',
            'acte_etat_civil[prenoms]' => 'Testing',
            'acte_etat_civil[dateNaissance]' => 'Testing',
            'acte_etat_civil[lieuNaissance]' => 'Testing',
            'acte_etat_civil[nomPere]' => 'Testing',
            'acte_etat_civil[nomMere]' => 'Testing',
            'acte_etat_civil[typeActe]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->acteEtatCivilRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new ActeEtatCivil();
        $fixture->setNumeroActe('My Title');
        $fixture->setPrenoms('My Title');
        $fixture->setDateNaissance('My Title');
        $fixture->setLieuNaissance('My Title');
        $fixture->setNomPere('My Title');
        $fixture->setNomMere('My Title');
        $fixture->setTypeActe('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('ActeEtatCivil');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new ActeEtatCivil();
        $fixture->setNumeroActe('Value');
        $fixture->setPrenoms('Value');
        $fixture->setDateNaissance('Value');
        $fixture->setLieuNaissance('Value');
        $fixture->setNomPere('Value');
        $fixture->setNomMere('Value');
        $fixture->setTypeActe('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'acte_etat_civil[numeroActe]' => 'Something New',
            'acte_etat_civil[prenoms]' => 'Something New',
            'acte_etat_civil[dateNaissance]' => 'Something New',
            'acte_etat_civil[lieuNaissance]' => 'Something New',
            'acte_etat_civil[nomPere]' => 'Something New',
            'acte_etat_civil[nomMere]' => 'Something New',
            'acte_etat_civil[typeActe]' => 'Something New',
        ]);

        self::assertResponseRedirects('/acte/etat/civil/');

        $fixture = $this->acteEtatCivilRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getNumeroActe());
        self::assertSame('Something New', $fixture[0]->getPrenoms());
        self::assertSame('Something New', $fixture[0]->getDateNaissance());
        self::assertSame('Something New', $fixture[0]->getLieuNaissance());
        self::assertSame('Something New', $fixture[0]->getNomPere());
        self::assertSame('Something New', $fixture[0]->getNomMere());
        self::assertSame('Something New', $fixture[0]->getTypeActe());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new ActeEtatCivil();
        $fixture->setNumeroActe('Value');
        $fixture->setPrenoms('Value');
        $fixture->setDateNaissance('Value');
        $fixture->setLieuNaissance('Value');
        $fixture->setNomPere('Value');
        $fixture->setNomMere('Value');
        $fixture->setTypeActe('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/acte/etat/civil/');
        self::assertSame(0, $this->acteEtatCivilRepository->count([]));
    }
}
