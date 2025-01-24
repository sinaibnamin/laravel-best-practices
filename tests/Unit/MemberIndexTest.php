<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\Member;

class MemberIndexTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_retrieves_all_members_without_filters()
    {
        // Act
        $response = $this->getJson('/api/members');

        // Assert
        $response->assertStatus(200)
                 ->assertJson(['success' => true]);

        // Ensure data is returned
        $this->assertNotEmpty($response->json('data'));
    }

    /** @test */
    public function it_filters_members_by_full_name()
    {
        // Ensure test environment has a member with specific data
        $member = Member::firstWhere('full_name', 'LIKE', '%md%');

        if (!$member) {
            $this->markTestSkipped('No member with full_name containing "John" exists in the database.');
        }

        // Act
        $response = $this->getJson('/api/members?full_name=John');

        // Assert
        $response->assertStatus(200);
    }

    /** @test */
    // public function it_filters_members_by_status()
    // {
    //     // Ensure test environment has a member with specific status
    //     $member = Member::firstWhere('status', 'active');

    //     if (!$member) {
    //         $this->markTestSkipped('No member with status "active" exists in the database.');
    //     }

    //     // Act
    //     $response = $this->getJson('/api/members?status=active');

    //     // Assert
    //     $response->assertStatus(200)
    //              ->assertJson(['success' => true])
    //              ->assertJsonFragment(['status' => 'active']);
    // }

    /** @test */
    // public function it_returns_empty_array_if_no_members_match_filters()
    // {
    //     // Act
    //     $response = $this->getJson('/api/members?full_name=Nonexistent');

    //     // Assert
    //     $response->assertStatus(200)
    //              ->assertJson(['success' => true, 'data' => []]);
    // }

    /** @test */
    // public function it_handles_server_errors_gracefully()
    // {
    //     // Mock an exception
    //     $this->mock(Member::class, function ($mock) {
    //         $mock->shouldReceive('query')->andThrow(new \Exception('Unexpected error'));
    //     });

    //     // Act
    //     $response = $this->getJson('/api/members');

    //     // Assert
    //     $response->assertStatus(500)
    //              ->assertJson(['success' => false])
    //              ->assertJsonFragment(['error' => 'An error occurred while fetching members.']);
    // }
}
