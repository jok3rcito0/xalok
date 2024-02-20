<?php

namespace App\Controller;

use App\Entity\Driver;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DriverController extends AbstractController
{
    #[Route('/driver', name: 'driver_index', methods: ['GET'])]
    public function index(PersistenceManagerRegistry $doctrine): JsonResponse
    {
        $drivers = $doctrine->getRepository(Driver::class)->findAll();
        return $this->json($drivers);
    }

    #[Route('/driver/{id}', name: 'driver_show', methods: ['GET'])]
    public function show(int $id, PersistenceManagerRegistry $doctrine): Response
    {
        $driver = $doctrine->getRepository(Driver::class)->find($id);

        if (!$driver) {
            return $this->json(['message' => 'Vehicle not found'], 404);
        }

        return $this->render('base.html.twig', [
            'number' => $driver->getName(),
        ]);
        //return $this->json($driver->getName());
    }

    #[Route('/driver', name: 'driver_create', methods: ['POST'])]
    public function create(Request $request, PersistenceManagerRegistry $doctrine): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $driver = new Driver();
        $driver->setName($data['name']);
        $driver->setSurname($data['surname']);
        $driver->setLicense($data['license']);
        $entityManager = $doctrine->getManager();
        $entityManager->persist($driver);
        $entityManager->flush();
        return $this->json($driver, 201);
    }

    #[Route('/driver/{id}', name: 'driver_update', methods: ['PUT'])]
    public function update(Request $request, int $id, PersistenceManagerRegistry $doctrine): JsonResponse
    {
        $entityManager = $doctrine->getManager();
        $driver = $entityManager->getRepository(Driver::class)->find($id);
        if (!$driver) {
            return $this->json(['message' => 'Driver not found'], 404);
        }
        $data = json_decode($request->getContent(), true);
        $driver->setName($data['name']);
        $driver->setSurname($data['surname']);
        $driver->setLicense($data['license']);
        $entityManager->flush();
        return $this->json($driver);
    }

    #[Route('/driver/{id}', name: 'driver_delete', methods: ['DELETE'])]
    public function delete(int $id, PersistenceManagerRegistry $doctrine): JsonResponse
    {
        $entityManager = $doctrine->getManager();
        $driver = $entityManager->getRepository(Driver::class)->find($id);
        if (!$driver) {
            return $this->json(['message' => 'Vehicle not found'], 404);
        }
        $entityManager->remove($driver);
        $entityManager->flush();
        return new JsonResponse(null, 204);
    }
}
