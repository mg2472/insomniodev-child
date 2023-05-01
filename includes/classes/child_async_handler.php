<?php

if (!defined('ABSPATH')) exit; //Exit if accessed directly.

/**
 * Main child theme async requests handler class
 * @version 0.0.1
 */
class IdtChildAsyncHandler
{

    /**
     * Controller for the incoming fetch requests
     * @version 0.0.1
     */
    public static function idtRequestsRouter()
    {
        $data = file_get_contents("php://input");

        $response = [
            'body' => '',
            'errors' => [],
            'status' => 0
        ];

        if (isset($data)) {
            $data = json_decode($data);
            $group = $data->group;
            $method = $data->method;
            $args = $data->data;

            switch ($group) {
                case 'validations':
                    require_once IDT_THEME_PATH . '/includes/classes/idt_validations.php';
                    $validations = new IdtValidations();

                    switch ($method) {
                        case 'checkUrlExist':
                            $response['body'] = $validations->checkUrlExist($args);
                            $response['status'] = 200;
                            break;
                        case 'serverSideValidations':
                            if (!empty($args)) {
                                $response['body'] = [];
                                foreach ($args as $arg) {
                                    switch ($arg->validation) {
                                        case 'validateExcludeExpList':
                                            if ($validations->stringIsInExclusionList($arg->value, $arg->excludesList)) {
                                                $response['body'] = false;
                                                if (isset($arg->errorMsg) && $arg->errorMsg != '') {
                                                    $response['errors'][] = $arg->errorMsg;
                                                } else {
                                                    $response['errors'][] = __('A field has an illegal value. Check again.', 'insomniodev');
                                                }
                                            } else {
                                                $response['body'][] = [
                                                    'validation' => 'validateExcludeExpList',
                                                    'value' => true
                                                ];
                                            }
                                            break;
                                        case 'validateUrlExist':
                                            if ($validations->checkUrlExist($arg->value)) {
                                                $response['body'][] = [
                                                    'validation' => 'validateUrlExist',
                                                    'value' => true
                                                ];
                                            } else {
                                                $response['body'] = false;
                                                if (isset($arg->errorMsg) && $arg->errorMsg != '') {
                                                    $response['errors'][] = $arg->errorMsg;
                                                } else {
                                                    $response['errors'][] = __('The url entered does not exist. Check again.', 'insomniodev');
                                                }
                                            }
                                            break;
                                        default:
                                            $response['body'] = false;
                                            break;
                                    }
                                }
                            }
                            $response['status'] = 200;
                            break;
                        default:
                            $response['errors'][] = __('No method match for the query.', 'insomniodev');
                            $response['status'] = 404;
                            break;
                    }
                    break;
                default:
                    $response['errors'][] = __('No request group match for the query.', 'insomniodev');
                    $response['status'] = 404;
                    break;
            }

        } else {
            $response['errors'][] = __('Empty data.', 'insomniodev');
            $response['status'] = 200;
        }

        echo json_encode($response);
        wp_die();
    }
}