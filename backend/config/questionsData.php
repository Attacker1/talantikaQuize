<?php

return [
  'questions' => [
      [
          'id' => 1,
          'questionType' => 'radio',
          'order' => '1',
          'right_order' => '3',
          'wrong_order' => '2',
          'title' => 'Чему равно следующее выражение? 5!',
          'rightAnswer' => ['120'],
          'wrongAnswers' => ['5'],
          'timer' => null,
          'timer_up_order' => null,
          'isPrize' => false,
          'frozenTime' => null
      ],
      [
          'id' => 2,
          'questionType' => 'text',
          'order' => '2',
          'right_order' => '3',
          'wrong_order' => '1',
          'title' => 'Как называется косметический бренд компании Shiawasedo?',
          'rightAnswer' => 'Summus',
          'wrongAnswers' => [],
          'timer' => null,
          'timer_up_order' => null,
          'isPrize' => false,
          'frozenTime' => null
      ],
      [
          'id' => 3,
          'questionType' => 'checkbox',
          'order' => '1',
          'right_order' => '6',
          'wrong_order' => '4',
          'title' => 'Отметьте среди указанных все простые числа:',
          'rightAnswer' => ['2', '11'],
          'wrongAnswers' => ['4', '8', '22'],
          'timer' => null,
          'timer_up_order' => null,
          'isPrize' => true,
          'frozenTime' => '600'
      ],
      [
          'id' => 4,
          'questionType' => 'radio',
          'order' => '1',
          'right_order' => '6',
          'wrong_order' => '5',
          'title' => 'Как расшифровывается аббревиатура PHP?',
          'rightAnswer' => ['HP: Hypertext Preprocessor'],
          'wrongAnswers' => ['Phenomenal Human Programmer', 'Никак, это просто 3 буквы без смысла'],
          'timer' => '60',
          'timer_up_order' => '2',
          'isPrize' => false,
          'frozenTime' => null
      ],
      [
          'id' => 5,
          'questionType' => 'number',
          'order' => '1',
          'right_order' => '7',
          'wrong_order' => '2',
          'title' => 'Чему равно выражение 3^2?',
          'rightAnswer' => ['9'],
          'wrongAnswers' => [],
          'timer' => null,
          'timer_up_order' => null,
          'isPrize' => false,
          'frozenTime' => null
      ],
      [
          'id' => 6,
          'questionType' => 'checkbox',
          'order' => '1',
          'right_order' => '7',
          'wrong_order' => null,
          'title' => 'Что вы сейчас чувствуете?',
          'rightAnswer' => ['Счастье', 'Любовь', 'Радость'],
          'wrongAnswers' => null,
          'timer' => null,
          'timer_up_order' => null,
          'isPrize' => false,
          'frozenTime' => null
      ],
      [
          'id' => 7,
          'questionType' => 'textarea',
          'order' => '1',
          'right_order' => '',
          'wrong_order' => '',
          'title' => 'У компании Shiawasedo скоро день рождения. Напишите идеальное поздравление компании',
          'rightAnswer' => null,
          'wrongAnswers' => null,
          'timer' => '600',
          'timer_up_order' => '4',
          'isPrize' => false,
          'frozenTime' => null
      ],
  ]
];
