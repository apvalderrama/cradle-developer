<?php //-->
/**
 * This file is part of the Cradle PHP Kitchen Sink Faucet Project.
 * (c) 2016-2018 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

use Cradle\Framework\CommandLine;

/**
 * CLI faucet starting point
 *
 * @param Request $request
 * @param Response $response
 *
 * @return string
 */
return function ($request, $response) {
    $event = 'help';

    if($request->hasStage(0)) {
        $event = $request->getStage(0);
        $request->removeStage(0);
    }


    if($request->hasStage()) {
        $data = [];
        $stage = $request->getStage();
        foreach($stage as $key => $value) {
            if(!is_numeric($key)) {
                $data[$key] = $value;
            } else {
                $data[$key - 1] = $value;
            }

            $request->removeStage($key);
        }

        $request->setStage($data);
    }

    $this->trigger('deploy-' . $event, $request, $response);
};
