<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 13.10.2022
 * Time: 09:03
 */

namespace Bitrix24\Models\Crm\Lead;


use Bitrix24\Abstracts\Models;
use Bitrix24\Interfaces\IMethod;
use Bitrix24\Interfaces\IModels;
use Bitrix24\Method\User\Search;
use Bitrix24\Model;

/**
 * @property int $ID
 * @property string $TITLE
 * @property string $SOURCE_ID
 * @property string $NAME
 * @property string $LAST_NAME
 * @property string $SECOND_NAME
 * @property array $WEB
 * @property boolean $HAS_PHONE
 * @property array $PHONE
 * @property boolean $HAS_EMAIL
 * @property array $EMAIL
 * @property string $ADDRESS
 * @property string $ADDRESS_2
 * @property string $ADDRESS_CITY
 * @property string $ADDRESS_COUNTRY
 * @property string $ADDRESS_COUNTRY_CODE
 * @property string $ADDRESS_POSTAL_CODE
 * @property string $ADDRESS_PROVINCE
 * @property string $ADDRESS_REGION
 * @property int $ADDRESS_LOC_ADDR_ID
 * @property int $ASSIGNED_BY_ID
 * @property string $BIRTHDATE
 * @property string $COMMENTS
 * @property int $COMPANY_ID
 * @property string $COMPANY_TITLE
 * @property int $CONTACT_ID
 * @property int $CREATED_BY_ID
 * @property string $STATUS_ID
 * @property string $STATUS_DESCRIPTION
 * @property string $CURRENCY_ID
 * @property string $DATE_CLOSED
 * @property string $DATE_CREATE
 * @property string $DATE_MODIFY
 * @property boolean $OPENED
 * @property boolean $IS_RETURN_CUSTOMER
 * @property int $MODIFY_BY_ID
 * @property int $MOVED_BY_ID
 * @property string $MOVED_TIME
 * @property string $OPPORTUNITY
 * @property string $ORIGINATOR_ID
 * @property string $ORIGIN_ID
 * @property string $SOURCE_DESCRIPTION
 * @property string $POST
 * @property string $HONORIFIC
 * @property string $UTM_CAMPAIGN
 * @property string $UTM_CONTENT
 * @property string $UTM_MEDIUM
 * @property string $UTM_SOURCE
 * @property string $UTM_TERM
 * @property string $STATUS_SEMANTIC_ID
 * @property string $HAS_IMOL
 * @property string $IS_MANUAL_OPPORTUNITY
 */
class Get extends Models implements IModels
{
    public function __construct()
    {
        $this->setAlias('CHAT_ID', 'UF_CRM_1665621150592');
        $this->setAlias('ROISTAT_ID', 'UF_CRM_1662118608905');
        $this->setAlias('VISITOR_NUMBER', 'UF_CRM_1665550327787');
        $this->setAlias('PAGE_URL', 'UF_CRM_1663927628378');
        $this->setAlias('PAGE_TITLE', 'UF_CRM_1663927675305');
        $this->setAlias('SOURCE_1C', 'UF_CRM_1665568341670');
        parent::__construct();
    }

    public function parserComments($visitor, array $messages)
    {
        $msgs = '';
        if (!empty($messages)) {

            $msgs = '<b>Диалог из чата</b><br><br>';
            foreach ($messages as $message) {
                $type = $message['type'];
                $msg = $message['message'];

                $name = '';
                switch ($type) {
                    case 'visitor':
                        $type = 'Клиент';
                        $name = $visitor;
                        break;
                    case 'agent':
                        $type = 'Менеджер';

                        $agent_id = $this->get('ASSIGNED_BY_ID');
                        #$agent_id = $message['agent_id'];
                        $agentName = 'Не определен';
                        if ($User = Model::get('User', $agent_id)) {
                            $agentName = $User->get('NAME') . ' ' . $User->get('LAST_NAME');
                        }
                        $name = $agentName;
                        break;
                    default:
                        break;
                }
                $today = date('H:i:s d-m-y', $message['timestamp']);
                $msgs .= '<b>' . $type . ' ' . $name . '</b>' . ' - <em><small>' . $today . '</small></em><br>' . $msg . '<br><br>';
            }
        }
        return $msgs;
    }
}