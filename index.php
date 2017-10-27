<?php

require 'vendor/autoload.php';
require 'vendor/awsmug/alexa-php-sdk/src/alexa-sdk.php';
require 'bitso_skill.php';

use \Alexa\Exception;

$dotenv = new Dotenv\Dotenv( __DIR__ );
$dotenv->load();

$skill = new Bitso_Skill( getenv( 'SKILL_ID' ) );

try{
  $skill->run();
} catch( Exception $exception) {
  $skill->log( $exception->getMessage() );
}
