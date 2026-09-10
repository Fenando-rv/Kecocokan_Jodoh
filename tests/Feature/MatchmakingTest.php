<?php

namespace Tests\Feature;

use App\Services\MatchmakingService;
use Tests\TestCase;

class MatchmakingTest extends TestCase
{
    /**
     * Test home page returns HTTP 200 OK.
     */
    public function test_home_page_is_accessible(): void
    {
        $response = $this->get(route('matchmaker.index'));

        $response->assertStatus(200);
        $response->assertViewIs('matchmaker');
        $response->assertSee('Kalkulator Kecocokan Jodoh');
    }

    /**
     * Test valid matchmaking POST calculation.
     */
    public function test_matchmaking_calculation_success(): void
    {
        $response = $this->post(route('matchmaker.calculate'), [
            'person1_name' => 'Romeo',
            'person1_birthdate' => '1995-05-15',
            'person2_name' => 'Juliet',
            'person2_birthdate' => '1997-08-20',
        ]);

        $response->assertStatus(200);
        $response->assertViewIs('matchmaker');
        $response->assertViewHas('result');
        $response->assertSee('Romeo');
        $response->assertSee('Juliet');
    }

    /**
     * Test commutativity logic: (Person A + Person B) equals (Person B + Person A).
     */
    public function test_matchmaking_is_commutative(): void
    {
        $service = new MatchmakingService();

        $resultAB = $service->calculateMatch('Romeo', '1995-05-15', 'Juliet', '1997-08-20');
        $resultBA = $service->calculateMatch('Juliet', '1997-08-20', 'Romeo', '1995-05-15');

        $this->assertEquals($resultAB['score'], $resultBA['score']);
        $this->assertEquals($resultAB['category'], $resultBA['category']);
        $this->assertEquals($resultAB['narrative'], $resultBA['narrative']);
        $this->assertEquals($resultAB['breakdown'], $resultBA['breakdown']);
    }

    /**
     * Test determinism and normalization (spaces & casing difference).
     */
    public function test_matchmaking_normalization_and_determinism(): void
    {
        $service = new MatchmakingService();

        $result1 = $service->calculateMatch('  Romeo  ', '1995-05-15', 'JULIET', '1997-08-20');
        $result2 = $service->calculateMatch('romeo', '1995-05-15', 'juliet', '1997-08-20');

        $this->assertEquals($result1['score'], $result2['score']);
        $this->assertGreaterThanOrEqual(40, $result1['score']);
        $this->assertLessThanOrEqual(99, $result1['score']);
    }

    /**
     * Test validation failure when required fields are missing or invalid.
     */
    public function test_validation_errors_on_empty_fields(): void
    {
        $response = $this->post(route('matchmaker.calculate'), [
            'person1_name' => '',
            'person1_birthdate' => 'invalid-date',
            'person2_name' => 'A',
            'person2_birthdate' => '2099-01-01', // Future date
        ]);

        $response->assertSessionHasErrors([
            'person1_name',
            'person1_birthdate',
            'person2_name',
            'person2_birthdate'
        ]);
    }
}
