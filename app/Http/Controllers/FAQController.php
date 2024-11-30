<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

use App\Models\FAQ;
use App\Models\Questions;
use Illuminate\Support\Facades\Cache;

class FAQController extends Controller
{
    public function index()
    {
        $faqs = FAQ::latest()->take(5)->get(); // Fetch the latest 8 FAQs
        return view('home', compact('faqs'));
    }

    public function allFaqs()
    {
        $faqs = Questions::all(); // Fetch all FAQs for the FAQ page
        return view('faqs', compact('faqs'));
    }
    public function askQuestion(Request $request)
    {
        $question = $request->input('question');
        $questionPrompt = "The user asked: ". $question." 
        Please provide a clear and concise answer related to career opportunities in Sweden, living as a newcomer, finances, Skatteverket, healthcare, social services, employment, and student-related topics. 
        Prioritize practical guidance, resources, and any links on jobsinsweden.se that might help. You can include the links to exteranl websites aswell. 
        If the question is outside of these topics, politely say: 'Sorry, I cannot answer this question at the moment.
        Please structure the response always in HTML format to display neatly on a website, including paragraphs, bullet points, or links if relevant.
        Note: The question is related to jobsinsweden.se, so link to any useful information available on this site.";

        $similarQuestion = Questions::where('question', 'LIKE', '%' . $question . '%')->first();
        if ($similarQuestion) {
            return response()->json(['answer' => $similarQuestion->answer]);
        }
        $answer = $this->askOpenAI($question);
        $newQuestion = new Questions();
        $newQuestion->question = $question;
        $newQuestion->answer = $answer;
        $newQuestion->save();
        return response()->json(['answer' => $answer]);
    }

    public function askOpenAI($userQuestion)
    {
        $client = new Client();
        $response = $client->post('https://api.openai.com/v1/chat/completions', [
            'headers' => [
                'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'model' => 'gpt-4o',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => "You are a helpful assistant for the website jobsinsweden.se. Provide concise and accurate answers about living in Sweden, including topics like careers, Skatteverket registration, healthcare, finances, social services, student life, and general inquiries about Sweden. 
                        
                        Use HTML format in your responses, including <p>, <ul>, <li>, <strong> and <a> tags as needed. If relevant, include external links or resources, including those from jobsinsweden.se. If a question is unrelated to these topics, respond politely that you cannot answer the question."
                    ],
                    [
                        'role' => 'user',
                        'content' => $userQuestion,
                    ]
                ],
                'max_tokens' => 300,
                'temperature' => 0.5,
            ],
        ]);
        $data = json_decode($response->getBody(), true);
        return $data['choices'][0]['message']['content'] ?? null;
    }
    public function store(Request $request)
    {
        $request->validate([
            'faq_id' => 'required|integer',
            'vote_type' => 'required|string|in:upvote,downvote',
        ]);

        $faqId = $request->faq_id;
        $voteType = $request->vote_type;

        // Store votes in Cache or Database (if no login system)
        $voteKey = "faq-votes-{$faqId}";
        $votes = collect(Questions::where('id', $faqId)->select('up_votes', 'down_votes')->first());
        //return $votes['up_votes'];
        //Cache::get($voteKey, ['upvotes' => 0, 'downvotes' => 0]);
        $upVotes = $votes['up_votes'];
        $downVotes = $votes['down_votes'];
        if ($voteType === 'upvote') {
            $upVotes = $votes['up_votes'] + 1;
        } elseif ($voteType === 'downvote') {
            $downVotes = $votes['down_votes'] + 1;
        }
        Questions::where('id', $faqId)
            ->update([
                'up_votes' => $upVotes, 
                'down_votes'=>$downVotes
            ]);
        //Cache::put($voteKey, $votes, now()->addDays(30)); // Cache votes for 30 days

        return response()->json($votes);
    }
    public function answerPage($id, $title) {
        $qtnRespo = collect(Questions::where('id', $id)->first());
        return view('answer', compact('qtnRespo'));
    }
}
