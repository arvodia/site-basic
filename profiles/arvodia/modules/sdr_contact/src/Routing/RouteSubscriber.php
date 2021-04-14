<?php

namespace Drupal\sdr_contact\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

class RouteSubscriber extends RouteSubscriberBase {

    protected function alterRoutes(RouteCollection $collection) {
        if ($route = $collection->get('view.frontpage.page_1')) {
            $route->setRequirement('_access', 'TRUE');
        }
        if ($route = $collection->get('filter.tips_all')) {
            $route->setRequirement('_access', 'FALSE');
        }
    }

}
