<?php

namespace Tests\Unit;

use App\Services\GemmaAIService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GemmaAIServiceTest extends TestCase
{
    public function test_service_returns_structured_summary()
    {
        Http::fake([
            'generativelanguage.googleapis.com/*' => Http::response([
                'candidates' => [
                    [
                        'content' => [
                            'parts' => [
                                ['text' => "## 1 Overview\nTest overview\n## 2 Important Concepts\nConcept 1\n## 3 Key Definitions\nDef 1\n## 4 Important Formulae\nF1\n## 5 Examples\nEx 1\n## 6 Important Points\nP1\n## 7 Possible Examination Areas\nExam 1\n## 8 Revision Tips\nTip 1"]
                            ]
                        ]
                    ]
                ]
            ], 200),
        ]);

        $service = new GemmaAIService();
        $response = $service->summarizeDocument("Sample course material text.", [
            'name' => 'Prof Smith',
            'years_of_experience' => 10,
            'highest_qualification' => 'PhD',
        ]);

        $this->assertTrue($response['success']);
        $this->assertStringContainsString('## 1 Overview', $response['data']);
        $this->assertStringContainsString('## 8 Revision Tips', $response['data']);
    }

    public function test_handles_api_failure_gracefully()
    {
        Http::fake([
            'generativelanguage.googleapis.com/*' => Http::response([
                'error' => ['message' => 'Invalid API Key']
            ], 400),
        ]);

        $service = new GemmaAIService();
        $response = $service->summarizeDocument("Test text");

        $this->assertFalse($response['success']);
        $this->assertNotNull($response['error']);
    }
}
