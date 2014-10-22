<?php

namespace NomadicBits\CDRatorWebService;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class NomadicBitsCDRatorWebServiceBundle extends Bundle {
		
	public function build(ContainerBuilder $container) {
        parent::build($container);
    }
}