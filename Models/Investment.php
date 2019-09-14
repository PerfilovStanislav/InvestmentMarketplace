<?php

namespace Models {

    use Core\{
        Auth, Model
    };
    use Helpers\{
        Validator,
        Arrays,
        Data\Currency
    };

    class Investment extends Model{

        public function addProject(Validator $post) {
            if (strpos($post->ref_url, 'http://') === false && strpos($post->ref_url, 'https://') === false) {
                $post->ref_url = 'http://' . $post->ref_url;
            }
            // сохраняем информацию по проекту
            $in_data = [
                'name'               => [[$post->projectname]],
                'admin'              => [[1],                                \PDO::PARAM_INT],
                'url'                => [[$post->url]],
                'ref_url'            => [[$post->ref_url]],
                'paymenttype'        => [[$post->paymenttype],                \PDO::PARAM_INT],
                'start_date'         => [[$post->date]],
                'plan_percents'      => [[Arrays::toArrayForInsert($post->plan_percents)]],
                'plan_period'        => [[Arrays::toArrayForInsert($post->plan_period)]],
                'plan_period_type'   => [[Arrays::toArrayForInsert($post->plan_period_type)]],
                'plan_start_deposit' => [[Arrays::toArrayForInsert($post->plan_start_deposit)]],
                'plan_currency_type' => [[Arrays::toArrayForInsert($post->plan_currency_type)]],
                'ref_percent'        => [[Arrays::toArrayForInsert($post->ref_percent)]],
                'id_payments'        => [[Arrays::toArrayForInsert($post->id_payments)]],
                'status_id'          => [[(Auth::getUserInfo()['status_id'] ?? null) == 3 ? 2 : 1], \PDO::PARAM_INT],
            ];

            if (!$this->db->insert('project', $in_data)) return null;
            $project_id = $this->db->lastID('project');

            $this->db->insert('project_lang', [
                'project_id'   => [array_fill(0, count($post->description), $project_id), \PDO::PARAM_INT],
                'lang_id'      => [array_keys($post->description),              \PDO::PARAM_INT],
                'description'  => [array_values($post->description)],
            ]);
            return $project_id;
        }

        public function getRegistrationData() {
            return [
                'payments'  => $this->db->select('payments', 'id, name', null, 'pos'),
                'languages' => $this->db->select('languages', 'id, name, own_name, flag', 'pos is not null', 'pos'),
                'hidden_languages' => $this->db->select('languages', 'id, name, own_name, flag', 'pos is null', 'name'),
                'user_info' => Auth::getUserInfo()
            ];
        }

        public function getShowData(int $langId, int $status) : array {
            'SELECT
    p.id 
    , p.name 
    , p.url 
    , p.description
    , array_to_json(p.ref_percent) ref_percent
    , array_to_json(p.id_payments) id_payments
    , array_to_json(array_agg(ARRAY[p1, p2, p3, p4, p5])) plans
  , array_to_json(array_agg(lang_id)) as lang_ids
from (
    SELECT 
        p.id 
        , p.name 
        , p.url 
        , l.description
        , ref_percent
        , id_payments
        , unnest(p.plan_percents)      as p1
        , unnest(p.plan_period)        as p2
        , unnest(p.plan_period_type)   as p3 
        , unnest(p.plan_start_deposit) as p4 
        , unnest(p.plan_currency_type) as p5
        , pl2.lang_id
    FROM project p
    JOIN project_lang l ON p.id = l.project_id
  JOIN project_lang pl2 ON pl2.project_id = p.id
    WHERE l.lang_id = 317 and status_id = 1
) p
group by p.id 
    , p.name 
    , p.url 
    , p.description
  , p.ref_percent
  , p.id_payments
order by p.id desc;
';
            $projects = $this->db->getResult("
                SELECT p.id, p.name, p.url, l.description
                    , array_to_json(p.ref_percent) ref_percent
                    , array_to_json(p.id_payments) id_payments
                FROM project p
                JOIN project_lang l ON p.id = l.project_id
                WHERE l.lang_id = $langId and status_id = $status
                order by id desc
                limit 25
            ");

            if(!$projects) {
                return [];
            }

            $projectIds = array_column($projects, 'id');
            $projectIdsStr = implode(',', $projectIds);

            $plans = $this->db->getResult('
                SELECT id, array_to_json(array_agg(ARRAY[p1, p2, p3, p4, p5])) plan
                FROM (
                    SELECT id
                        , unnest(plan_percents)      as p1
                        , unnest(plan_period)        as p2
                        , unnest(plan_period_type)   as p3 
                        , unnest(plan_start_deposit) as p4 
                        , unnest(plan_currency_type) as p5 
                    FROM project WHERE id IN ('.$projectIdsStr.')
                ) tt
                GROUP BY id
            ');

            $projectLangs = $this->db->getResult('
                SELECT project_id, array_to_json(array_agg(lang_id)) as lang_id
                FROM project_lang WHERE project_id IN ('.$projectIdsStr.')
                GROUP BY project_id
            ');

            $languages = $this->db->getResult('
                SELECT l.id, l.name, l.own_name, l.flag
                FROM project_lang pl
                join languages l ON l.id = pl.lang_id
                where project_id IN ('.$projectIdsStr.')
                GROUP BY l.id, l.name, l.own_name, l.flag
            ');

            $payments = $this->db->getResult('
                SELECT pay.id, pay.name
                FROM project pr
                JOIN payments pay ON pay.id = ANY(pr.id_payments)
                WHERE pr.id IN ('.$projectIdsStr.')
                GROUP BY pay.id, pay.name
                ORDER BY pay.pos
            ');

            $arrayHelper = new Arrays();
            return [
                'projectIds'  => $projectIds,
                'projects'    => $arrayHelper->setArray($projects)->toArray(['id_payments', 'ref_percent'])->groupBy(['id'])->getArray(),
                'plans'       => $arrayHelper->setArray($plans)->toArray(['plan'])->groupBy(['id'])->getArray(),
                'projectLangs'=> $arrayHelper->setArray($projectLangs)->toArray(['lang_id'])->groupBy(['project_id'])->getArray(),
                'languages'   => $arrayHelper->setArray($languages)->groupBy(['id'])->getArray(),
                'payments'    => $arrayHelper->setArray($payments)->groupBy(['id'])->getArray(),
                'currency'    => Currency::getCurrency(),
            ];
        }

        public function getFilterLangs() : array {
            return array_column(
                $this->db->select('languages', 'id,name,own_name,flag,shortname', ['id' => [317,219]])
                , null, 'shortname'
            );
        }

        public function getChatMessages(array $chats) {
            $sql = implode(' UNION ALL ', array_map(
                function(array $a) {
                    return "
                        (SELECT m.id, m.date_create, m.user_id, m.project_id, m.message, m.session_id
                        FROM message m
                        WHERE m.project_id = {$a['id']} and m.id>{$a['max_id']} and m.lang_id = 219
                        ORDER BY m.id desc
                        limit 50)
                    ";
                }, $chats
            ));

            $chats = $this->db->getResult($sql);

            if (!$chats) return null;

            $arrayHelper = new Arrays();
            return $arrayHelper->setArray($chats)->groupBy(['project_id', 'id'])->getArray();
        }
    }
}
