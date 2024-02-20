<?php

namespace App\Controller;

use App\Entity\Vehicle;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class VehicleController extends AbstractController
{
    #[Route('/vehicles', name: 'vehicle_index', methods: ['GET'])]
    public function index(PersistenceManagerRegistry $doctrine): JsonResponse
    {
        $vehicles = $doctrine->getRepository(Vehicle::class)->findAll();
        return $this->json($vehicles);
    }

    #[Route('/vehicles/{id}', name: 'vehicle_show', methods: ['GET'])]
    public function show(int $id, PersistenceManagerRegistry $doctrine): JsonResponse
    {
        $vehicle = $doctrine->getRepository(Vehicle::class)->find($id);

        if (!$vehicle) {
            return $this->json(['message' => 'Vehicle not found'], 404);
        }
        return $this->json($vehicle);
    }

    #[Route('/vehicles', name: 'vehicle_create', methods: ['POST'])]
    public function create(Request $request, PersistenceManagerRegistry $doctrine): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $vehicle = new Vehicle();
        $vehicle->setBrand($data['brand']);
        $vehicle->setModel($data['model']);
        $vehicle->setPlate($data['plate']);
        $vehicle->setLicenseRequired($data['license_required']);
        $entityManager = $doctrine->getManager();
        $entityManager->persist($vehicle);
        $entityManager->flush();
        return $this->json($vehicle, 201);
    }

    #[Route('/vehicles/{id}', name: 'vehicle_update', methods: ['PUT'])]
    public function update(Request $request, int $id, PersistenceManagerRegistry $doctrine): JsonResponse
    {
        $entityManager = $doctrine->getManager();
        $vehicle = $entityManager->getRepository(Vehicle::class)->find($id);
        if (!$vehicle) {
            return $this->json(['message' => 'Vehicle not found'], 404);
        }
        $data = json_decode($request->getContent(), true);
        $vehicle->setBrand($data['brand']);
        $vehicle->setModel($data['model']);
        $vehicle->setPlate($data['plate']);
        $vehicle->setLicenseRequired($data['license_required']);
        $entityManager->flush();
        return $this->json($vehicle);
    }

    #[Route('/vehicles/{id}', name: 'vehicle_delete', methods: ['DELETE'])]
    public function delete(int $id, PersistenceManagerRegistry $doctrine): JsonResponse
    {
        $entityManager = $doctrine->getManager();
        $vehicle = $entityManager->getRepository(Vehicle::class)->find($id);
        if (!$vehicle) {
            return $this->json(['message' => 'Vehicle not found'], 404);
        }
        $entityManager->remove($vehicle);
        $entityManager->flush();
        return new JsonResponse(null, 204);
    }
}
