<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\negocio\Projeto;

/**
 * ProjetoSearch represents the model behind the search form about `app\models\activerecord\Projeto`.
 */
class ProjetoSearch extends Projeto
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['_id', 'titulo', 'resumo', 'descricao', 'categoria_id', 'etapa', 'slug', 'url_externa', 'owner_id', 'foto_capa', 'anexo_titulo', 'anexo', 'created_at', 'updated_at'], 'safe'],
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
        $query = Projeto::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', '_id', $this->_id])
            ->andFilterWhere(['like', 'titulo', $this->titulo])
            ->andFilterWhere(['like', 'resumo', $this->resumo])
            ->andFilterWhere(['like', 'descricao', $this->descricao])
            ->andFilterWhere(['like', 'categoria_id', $this->categoria_id])
            ->andFilterWhere(['like', 'etapa', $this->etapa])
            ->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'url_externa', $this->url_externa])
            ->andFilterWhere(['like', 'owner_id', $this->owner_id])
            ->andFilterWhere(['like', 'foto_capa', $this->foto_capa])
            ->andFilterWhere(['like', 'anexo_titulo', $this->anexo_titulo])
            ->andFilterWhere(['like', 'anexo', $this->anexo])
            ->andFilterWhere(['like', 'created_at', $this->created_at])
            ->andFilterWhere(['like', 'updated_at', $this->updated_at]);

        return $dataProvider;
    }
}
