<?php


namespace App\Service;

use App\Messenger\Messages\Aws;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class AwsManager
 * @package App\Service
 *
 * Simulate s3 upload
 */
class AwsManager
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var array
     */
    private $pdfDirectories;
    /**
     * @var ClientRepository
     */
    private $repository;

    /**
     * AwsManager constructor.
     * @param EntityManagerInterface $em
     * @param ClientRepository $clientRepository
     * @param array $pdfDirectories
     */
    public function __construct(EntityManagerInterface $em, ClientRepository $clientRepository, array $pdfDirectories)
    {
        $this->em = $em;
        $this->pdfDirectories = $pdfDirectories;
        $this->repository = $clientRepository;
    }

    public function uploadToAws(Aws $aws)
    {
        $client = $this->repository->find($aws->getClient()->getId());

        if (true === $client->getUploaded()) {
            return;
        }

        $originalFile = $this->pdfDirectories['tmp'] . $client->getPdf();

        $fs = new Filesystem();

        $newFile = $this->pdfDirectories['aws'] . $client->getPdf();
        $fs->copy($originalFile, $newFile);

        $fs->remove($originalFile);

        $client->setUploaded(true);
        $client->setPdf($newFile);

        $this->em->persist($client);
        $this->em->flush();
    }
}
