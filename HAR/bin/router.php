<?php

	define('EXCEPTION_LOG_FILE', 'error_log');
	$_SERVER = 'home.emberframework.com';
	require_once('/var/www/ember/system/include/common.inc.php');
#	Debug::enable();
	
	$wemo_ip = Site::getSetting('wemo_ip');
	$hue_ip = Site::getSetting('hue_ip');
	$hue_hash = Site::getSetting('hue_token');

	$sleep = 7;
	$recover_sleep = 30;
	
	$switch = new WeMo_Switch($wemo_ip);
	$base = new Hue_Base($hue_ip, $hue_hash);
	
	$lights = $base->getLights();
	
	$current_light_state = Hue_Light::STATE_OFF;
	$current_switch_state = $switch->getState();
	
	while(true)
	{
		try{
			$prev_light_state = $current_light_state;
			$current_light_state = Hue_Light::STATE_OFF;
			foreach($lights as $l=>$name)
			{
				$light = $base->getLightObj($l);
				if($light->isOn())
				{
					$current_light_state = Hue_Light::STATE_ON;
					break;
				}
			}
		}catch(Exception $e)
		{
			echo 'Error with Hue'.PHP_EOL;
			$current_light_state = $prev_light_state;
			sleep($recover_sleep);
		}

		$prev_switch_state = $current_switch_state;
		try{
		$current_switch_state = $switch->getState();
		}catch(Exception $e)
		{
			echo 'Error with GetSwitchState'.PHP_EOL;
			$switch->closeConnection();
			$current_switch_state = $prev_switch_state;
			sleep($recover_sleep);
		}

		if($prev_switch_state != $current_switch_state)
		{
			//Switch Lights to match
			switch($current_switch_state)
			{
				case WeMo_Switch::ON: $lstate = Hue_Light::STATE_ON; echo'Turning Lights On'.PHP_EOL; break;
				case WeMo_Switch::OFF: $lstate = Hue_Light::STATE_OFF; echo'Turning Lights Off'.PHP_EOL; break;
			}

			foreach($lights as $l=>$name)
			{
				$light = $base->getLightObj($l);
				$light->setON($lstate);
				$base->sendLight($light);
			}
		}
		elseif($current_light_state != $current_switch_state)
		{
			//Change the switch
			switch($current_light_state)
			{
				case Hue_Light::STATE_ON: $sstate = WeMo_Switch::ON; echo'Turning On Switch'.PHP_EOL; break;
				case Hue_Light::STATE_OFF: $sstate = WeMo_Switch::OFF; echo'Turning Off Switch'.PHP_EOL; break;
			}
			
			$switch->setState($sstate);
			$current_switch_state = $switch->getState();
		}

		$switch->closeConnection();
		sleep($sleep);
	}
