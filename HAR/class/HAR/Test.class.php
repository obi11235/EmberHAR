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

		$base = new Hue_Base('192.168.1.149', 'dedaffc8e48643efddd9e5472200c77a');

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

		$base = new Hue_Base('192.168.1.149', 'dedaffc8e48643efddd9e5472200c77a');

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

		$base = new Hue_Base('192.168.1.149', 'dedaffc8e48643efddd9e5472200c77a');

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