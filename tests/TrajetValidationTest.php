<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;

/**
 * Tests unitaires pour la validation des trajets.
 * Ces tests vérifient les règles métier sans connexion à la base de données.
 */
class TrajetValidationTest extends TestCase
{
    // -------------------------------------------------------------------------
    // Helpers : reproduit la logique de TrajetController::validateTrajet()
    // -------------------------------------------------------------------------

    /**
     * @param array<string, mixed> $data
     * @return array<string, string>
     */
    private function validateTrajet(array $data): array
    {
        $errors = [];

        $departId  = (int) ($data['agence_depart_id']  ?? 0);
        $arriveeId = (int) ($data['agence_arrivee_id'] ?? 0);
        $gdhDepart  = $data['gdh_depart']  ?? '';
        $gdhArrivee = $data['gdh_arrivee'] ?? '';
        $places     = (int) ($data['places_totales'] ?? 0);

        if ($departId === 0) {
            $errors['agence_depart_id'] = 'Veuillez sélectionner une agence de départ.';
        }

        if ($arriveeId === 0) {
            $errors['agence_arrivee_id'] = 'Veuillez sélectionner une agence d\'arrivée.';
        }

        if ($departId !== 0 && $departId === $arriveeId) {
            $errors['agences'] = 'Les agences de départ et d\'arrivée doivent être différentes.';
        }

        if (empty($gdhDepart)) {
            $errors['gdh_depart'] = 'La date et heure de départ sont obligatoires.';
        }

        if (empty($gdhArrivee)) {
            $errors['gdh_arrivee'] = 'La date et heure d\'arrivée sont obligatoires.';
        }

        if (!empty($gdhDepart) && !empty($gdhArrivee) && $gdhArrivee <= $gdhDepart) {
            $errors['dates'] = 'La date d\'arrivée doit être postérieure à la date de départ.';
        }

        if ($places < 1 || $places > 9) {
            $errors['places_totales'] = 'Le nombre de places doit être compris entre 1 et 9.';
        }

        return $errors;
    }

    // -------------------------------------------------------------------------
    // Tests
    // -------------------------------------------------------------------------

    public function testTrajetValideRetourneAucuneErreur(): void
    {
        $errors = $this->validateTrajet([
            'agence_depart_id'  => 1,
            'agence_arrivee_id' => 2,
            'gdh_depart'        => '2027-01-15T08:00',
            'gdh_arrivee'       => '2027-01-15T12:00',
            'places_totales'    => 3,
        ]);

        $this->assertEmpty($errors);
    }

    public function testAgencesDepartEtArriveeIdentiquesRetourneErreur(): void
    {
        $errors = $this->validateTrajet([
            'agence_depart_id'  => 2,
            'agence_arrivee_id' => 2,
            'gdh_depart'        => '2027-01-15T08:00',
            'gdh_arrivee'       => '2027-01-15T12:00',
            'places_totales'    => 3,
        ]);

        $this->assertArrayHasKey('agences', $errors);
    }

    public function testDateArriveeAvantDateDepartRetourneErreur(): void
    {
        $errors = $this->validateTrajet([
            'agence_depart_id'  => 1,
            'agence_arrivee_id' => 2,
            'gdh_depart'        => '2027-01-15T12:00',
            'gdh_arrivee'       => '2027-01-15T08:00',
            'places_totales'    => 3,
        ]);

        $this->assertArrayHasKey('dates', $errors);
    }

    public function testDateArriveeEgaleADateDepartRetourneErreur(): void
    {
        $errors = $this->validateTrajet([
            'agence_depart_id'  => 1,
            'agence_arrivee_id' => 2,
            'gdh_depart'        => '2027-01-15T08:00',
            'gdh_arrivee'       => '2027-01-15T08:00',
            'places_totales'    => 3,
        ]);

        $this->assertArrayHasKey('dates', $errors);
    }

    public function testZeroPlaceRetourneErreur(): void
    {
        $errors = $this->validateTrajet([
            'agence_depart_id'  => 1,
            'agence_arrivee_id' => 2,
            'gdh_depart'        => '2027-01-15T08:00',
            'gdh_arrivee'       => '2027-01-15T12:00',
            'places_totales'    => 0,
        ]);

        $this->assertArrayHasKey('places_totales', $errors);
    }

    public function testDixPlacesRetourneErreur(): void
    {
        $errors = $this->validateTrajet([
            'agence_depart_id'  => 1,
            'agence_arrivee_id' => 2,
            'gdh_depart'        => '2027-01-15T08:00',
            'gdh_arrivee'       => '2027-01-15T12:00',
            'places_totales'    => 10,
        ]);

        $this->assertArrayHasKey('places_totales', $errors);
    }

    public function testChampsDepartManquantsRetourneErreurs(): void
    {
        $errors = $this->validateTrajet([]);

        $this->assertArrayHasKey('agence_depart_id',  $errors);
        $this->assertArrayHasKey('agence_arrivee_id', $errors);
        $this->assertArrayHasKey('gdh_depart',        $errors);
        $this->assertArrayHasKey('gdh_arrivee',       $errors);
    }

    public function testCreationTrajetAvecUneSeulePlaceEstValide(): void
    {
        $errors = $this->validateTrajet([
            'agence_depart_id'  => 1,
            'agence_arrivee_id' => 3,
            'gdh_depart'        => '2027-03-01T07:00',
            'gdh_arrivee'       => '2027-03-01T11:30',
            'places_totales'    => 1,
        ]);

        $this->assertEmpty($errors);
    }

    public function testCreationTrajetAvecNeufPlacesEstValide(): void
    {
        $errors = $this->validateTrajet([
            'agence_depart_id'  => 1,
            'agence_arrivee_id' => 3,
            'gdh_depart'        => '2027-03-01T07:00',
            'gdh_arrivee'       => '2027-03-01T11:30',
            'places_totales'    => 9,
        ]);

        $this->assertEmpty($errors);
    }
}
