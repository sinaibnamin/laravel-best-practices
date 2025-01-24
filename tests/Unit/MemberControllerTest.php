<?php

namespace Tests\Unit;

use App\Http\Controllers\MemberController;
use Illuminate\Http\Request;
use Mockery;
use Tests\TestCase;
use App\Models\Member;


class MemberControllerTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testIndexReturnsMembers()
    {
        // Mock the Request object
        $mockRequest = Mockery::mock(Request::class);
        $mockRequest->shouldReceive('all')->andReturn([]); // Simulate no filters being passed
        $mockRequest->shouldReceive('route')->andReturn(null); // Simulate route call returning null or expected value
    
        // Mock the Member query and methods
        $mockQuery = Mockery::mock();
        $mockQuery->shouldReceive('where')->andReturnSelf(); // Mocking potential where clause
        $mockQuery->shouldReceive('get')->andReturn(collect([
            (object) ['id' => 1, 'full_name' => 'John Doe'], // Ensure these match the controller's expectations
        ]));
    
        // Mock the static method query on the Member model
        $mockMember = Mockery::mock('alias:App\Models\Member');
        $mockMember->shouldReceive('query')->andReturn($mockQuery);
    
        // Instantiate the controller
        $controller = new MemberController();
    
        // Call the index method
        $response = $controller->index($mockRequest);
    
        // Decode the response
        $responseContent = $response->getData(true);
    
        // Assertions
        $this->assertTrue($responseContent['success'], 'Response success is not true');
        $this->assertEquals('Members retrieved successfully.', $responseContent['message']);
        $this->assertCount(1, $responseContent['data']);
    }
    
    
    
    public function testCreateMember()
    {
        $memberData = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            // Add other relevant fields here
        ];

        $response = $this->postJson('/api/members', $memberData); 

        $response->assertStatus(201); 
        $this->assertDatabaseHas('members', $memberData); 

        // Clean up any data created during the test
        Member::where('email', 'john.doe@example.com')->delete(); 
    }
    
    


    
    
    
    
    

    public function testShowReturnsMemberDetails()
    {
        $mockRequest = Mockery::mock(Request::class);
        $mockRequest->shouldReceive('validate')->andReturn(['id' => 1]);

        $mockMember = Mockery::mock('alias:App\\Models\\Member');
        $mockMember->shouldReceive('find')->with(1)->andReturn(['id' => 1, 'full_name' => 'John Doe']);

        $controller = new MemberController();
        $response = $controller->show($mockRequest);

        $responseContent = $response->getData(true);

        $this->assertTrue($responseContent['success']);
        $this->assertEquals('Member retrieved successfully.', $responseContent['message']);
    }

    public function testDestroyDeletesMember()
    {
        $mockMember = Mockery::mock('alias:App\\Models\\Member');
        $mockMember->shouldReceive('find')->with(1)->andReturnSelf();
        $mockMember->shouldReceive('delete')->andReturn(true);

        $controller = new MemberController();
        $response = $controller->destroy(1);

        $responseContent = $response->getData(true);

        $this->assertTrue($responseContent['success']);
        $this->assertEquals('Member deleted successfully.', $responseContent['message']);
    }
}
