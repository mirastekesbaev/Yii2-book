<?php

namespace admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use admin\models\Book;
use yii\db\Query;

/**
 * BookSearch represents the model behind the search form about `admin\models\Book`.
 */
class BookSearch extends Book
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['id', 'page_count', 'language_id', 'library_id', 'publisher_id', 'type_id', 'status_id', 'edition'],
                'integer'
            ],
            [['internal_id', 'name', 'isbn', 'issn', 'description', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = (new Query())->from('book')
            ->select(['book.*', 'status.status', 'status.status_sk', 'type.type', 'type.type_sk'])
            ->leftJoin('status', 'status.id = book.status_id')
            ->leftJoin('type', 'type.id = book.type_id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'attributes' => [
                    'isbn',
                    'issn',
                    'type_id' => [//todo: not good solution for multi language site
                        'acs' => ['type_sk' => SORT_ASC],
                        'desc' => ['type_sk' => SORT_DESC],
                        'default' => SORT_ASC
                    ],
                    'status_id' => [//todo: not good solution for multi language site
                        'acs' => ['status_sk' => SORT_ASC],
                        'desc' => ['status_sk' => SORT_DESC],
                        'default' => SORT_ASC
                    ],
                    'name' => [
                        'asc' => ['book.name' => SORT_ASC],
                        'desc' => ['book.name' => SORT_DESC],
                        'default' => SORT_ASC,
                    ]
                ]
            ],
        ]);

        $this->load($params);
        //show all books where status != deleted
        if (isset($params['deleted']) && $params['deleted'] == 'true') {
            $query->andFilterWhere(['status_id' => Yii::$app->params['status']['deleted']]);
        } else {
            $query->andFilterWhere(['!=', 'status_id', Yii::$app->params['status']['deleted']]);
        }

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            $query->where('0=1');

            return $dataProvider;
        }

        /*$query->andFilterWhere([
//            'id' => $this->id,
//            'page_count' => $this->page_count,
//            'language_id' => $this->language_id,
//            'library_id' => $this->library_id,
//            'publisher_id' => $this->publisher_id,
//            'type_id' => $this->type_id,
            //'status_id' => $this->status_id,
//            'edition' => $this->edition,
            //'updated_at' => $this->updated_at,
        ]);*/

//        $query->andFilterWhere(['like', 'internal_id', $this->internal_id])
//            ->andFilterWhere(['like', 'name', $this->name])
//            ->andFilterWhere(['like', 'isbn', $this->isbn])
//            ->andFilterWhere(['like', 'issn', $this->issn])
//            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
