@extends('layouts.app')

@section('title', 'Mini Games - KidsLearn')

@section('content')
    <div class="header">
        <a href="{{ route('dashboard') }}" class="back-btn">⬅</a>
        <div class="title">
            <h3>Mini Games – Guess the Animal</h3>
            <p>Lets learn about animals</p>
        </div>
        <img src="{{ asset('img/mascot-regis.png') }}" class="mascot" alt="Mascot">
    </div>

    <div class="game-box">
        <img id="questionImage" src="{{ asset($question->image_path) }}" alt="Animal">
    </div>

    <h3 class="question">{{ $question->question }}</h3>

    <form id="quizForm">
        @csrf
        <input type="hidden" name="question_id" value="{{ $question->id }}">

        <div class="answers">
            @foreach ($question->options as $option)
                <label>
                    <input type="radio" name="answer" value="{{ $option }}">
                    <span>{{ strtoupper($option) }}</span>
                </label>
            @endforeach
        </div>

        <button type="submit" class="check-btn">PERIKSA</button>
    </form>

    <div id="result" class="result" style="display: none;"></div>

    <footer>
        KidsLearn © 2025 — Belajar Dengan Senang!
        <div class="icons">
            <img src="{{ asset('img/ig.png') }}" alt="Instagram">
            <img src="{{ asset('img/twt.png') }}" alt="Twitter">
            <img src="{{ asset('img/fb.png') }}" alt="Facebook">
        </div>
    </footer>
@endsection

@push('styles')
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
        }

        .back-btn {
            color: white;
            text-decoration: none;
            font-size: 28px;
        }

        .title {
            flex: 1;
            text-align: center;
            color: white;
        }

        .title h3 {
            font-size: 18px;
            margin-bottom: 5px;
        }

        .title p {
            font-size: 14px;
            opacity: 0.9;
        }

        .mascot {
            width: 50px;
        }

        .game-box {
            max-width: 400px;
            margin: 30px auto;
            padding: 30px;
            background: white;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .game-box img {
            max-width: 100%;
            height: auto;
        }

        .question {
            text-align: center;
            color: white;
            font-size: 24px;
            margin: 30px 0;
            text-transform: capitalize;
        }

        .answers {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            max-width: 500px;
            margin: 0 auto 30px;
        }

        .answers label {
            display: block;
            padding: 20px;
            background: white;
            border-radius: 15px;
            text-align: center;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .answers label:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .answers input[type="radio"] {
            display: none;
        }

        .answers input[type="radio"]:checked+span {
            color: #667eea;
            font-weight: bold;
        }

        .answers label:has(input:checked) {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .answers label:has(input:checked) span {
            color: white;
        }

        .answers span {
            font-size: 18px;
            font-weight: bold;
        }

        .check-btn {
            display: block;
            width: 200px;
            margin: 0 auto;
            padding: 15px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 15px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.2s;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .check-btn:hover {
            transform: scale(1.05);
        }

        .result {
            max-width: 600px;
            margin: 30px auto;
            padding: 20px;
            border-radius: 15px;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
        }

        .result.correct {
            background: #e0ffe0;
            color: #2f8d32;
        }

        .result.wrong {
            background: #ffe0e0;
            color: #d32f2f;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.getElementById('quizForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const data = Object.fromEntries(formData.entries());

            if (!data.answer) {
                alert('Pilih jawaban dulu ya!');
                return;
            }

            fetch("{{ route('quiz.check') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(data => {
                    const resultDiv = document.getElementById('result');
                    resultDiv.style.display = 'block';
                    resultDiv.className = 'result ' + data.result;
                    resultDiv.innerHTML = data.message;

                    if (data.xp_gained) {
                        resultDiv.innerHTML += '<br><strong>+' + data.xp_gained + ' XP</strong>';
                    }

                    // Reload after 3 seconds to get new question
                    setTimeout(() => {
                        window.location.reload();
                    }, 3000);
                })
                .catch(error => {
                    alert('Terjadi kesalahan. Coba lagi ya!');
                });
        });
    </script>
@endpush
