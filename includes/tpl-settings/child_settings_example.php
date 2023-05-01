<?php

if (!defined('ABSPATH')) exit; //Exit if accessed directly.

/**
 * Single Landing page settings class
 * @version 0.0.1
 */

class IdtChildSettingsExample
{
    /**
     * Return the template settings
     * @param $postID int Post ID
     * @return array Template settings
     */
    public function getSettings(int $postID = 0): array
    {
        $settings = [
            'section1' => [
                'layout' => [
                    'show' => null
                ],
                'args' => [
                    'arg1' => null,
                    'arg3' => null,
                    'arg4' => null
                ]
            ]
        ];

        $settings['section1']['args']['args1'] = 'Value';

        return $settings;
    }
}