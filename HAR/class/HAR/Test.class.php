<?php
/**
 * Description of Hue_Base
 *
 * @author paul
 */
class HAR_Test
{
	static function setAllLightsWhite($lstate)
	{

		$base = new Hue_Base(Site::getSetting('hue_ip'), Site::getSetting('hue_token'));

		$lights = $base->getLights();

		foreach($lights as $l=>$name)
		{
			$light = $base->getLightObj($l);
			$light->setXY(0.4443, 0.4064);
			$light->setBrightness(254);
			$light->setON($lstate);
			$base->sendLight($light);
		}

	}
	
	static function setAllLightsRed($lstate)
	{

		$base = new Hue_Base(Site::getSetting('hue_ip'), Site::getSetting('hue_token'));

		$lights = $base->getLights();

		foreach($lights as $l=>$name)
		{
			$light = $base->getLightObj($l);
			$light->setXY(0.4499, 0.3268);
			$light->setBrightness(96);
			$light->setON($lstate);
			$base->sendLight($light);
		}

	}
	
	static function setAllLightsBlue($lstate)
	{

		$base = new Hue_Base(Site::getSetting('hue_ip'), Site::getSetting('hue_token'));

		$lights = $base->getLights();

		foreach($lights as $l=>$name)
		{
			$light = $base->getLightObj($l);
			$light->setXY(0.1559, 0.0386);
			$light->setBrightness(128);
			$light->setON($lstate);
			$base->sendLight($light);
		}

	}
}