<?php

namespace App\Http\Controllers;

use App\Models\Quize;
use App\Models\Result;
use Carbon\Carbon;
use Illuminate\Http\Request;

class QuizeController extends Controller
{
    public function store(Request $request) {
        $request->validate([
            'status' => 'required'
        ]);

        return $request->user()->quizzes()->create($request->only([
            'status'
        ]));
    }

    public function show(Request $request, Quize $quize) {
        if($request->user()->id) {
            return config('questionsData.questions');
        }
        return response()->json(['message' => 'Cannot find this quize'], 404);
    }

    public function nextStep(Request $request){
        $request->validate([
            'question_id' => 'required',
            'question' => 'required',
            'isDone' => 'required',
            'isCorrect' => 'required',
            'isPrize' => 'required',
            'doneIn' => 'required_if:isDone,==,true'
        ]);

        $result = $request->user()->result()->firstOrCreate(['user_id' => $request->user()->id]);

        if($request->answer === [])
            $request->answer = null;

        $question = [
            'question_id' => $request->question_id,
            'question' => $request->question,
            'isCorrect' => $request->isCorrect,
            'answer' => $request->answer ?? null,
            'isPrize' => $request->isPrize
        ];
        if($request->freezeTo) {
            $question['frozenTo'] = Carbon::now()->addMinutes((int)$request->freezeTo / 60);
        }

        if(empty($result->results)) {
            $results = [$question];
        } else {
            $results = $result->results;
            array_push($results, $question);
        }
        $result->results = $results;
        $result->isDone = $request->isDone;
        if($request->isDone)
            $result->doneIn = date('Y-m-d H:i:s', strtotime($request->doneIn));

        $result->save();
        return $result;
    }

    public function results(Request $request) {
        $result = $request->user()->result()->first();
        return $result;
    }

    public function reset(Request $request) {
        $result = $request->user()->result()->delete();
        return true;
    }

}
