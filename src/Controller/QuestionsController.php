<?php

namespace App\Controller;

/**
 *
 * Questions Controller
 */

 class QuestionsController extends AppController
 {
     /**
     *@inheritdoc
     */

     public function initialize()
     {
         parent::initialize();
         //以下の1行を追加
         $this->loadModel('Answers');
     }

     /**
      *質問画面一覧
      * @return \Cake\Http\Response|void
      */

     public function index()
     {
         //ここに処理を書いていく
         $questions = $this->paginate($this->Questions->find(), [
              'order' => ['Questions.id' => 'DESC']
          ]);

         $this->set(compact('questions'));
     }

     public function add()
     {
         $question = $this->Questions->newEntity();

         if ($this->request->is('post')) {
             $question = $this->Questions->patchEntity($question, $this->request->getData());
              
          
             $question->user_id = 1; //@TODO ユーザ管理機能実装時に修正する

             if ($this->Questions->save($question)) {
                 $this->Flash->success('質問を投稿しました');

                 return $this->redirect(['action' => 'index']);
             }
             $this->Flash->error('質問の投稿に失敗しました');
         }
         $this->set(compact('question'));
     }
     /**
     *質問詳細画面
     */
     public function view(int $id)
     {
         $question = $this->Questions->get($id);

         $answers = $this
         ->Answers
         ->find()
         ->where(['Answers.question_id' => $id])
         ->orderAsc('Answers.id')
         ->all();

         $newAnswer = $this->Answers->newEntity();

         $this->set(compact('question', 'answers', 'newAnswer'));
     }
 }
