<?php

namespace Tclievelde\API\endpoints;

use Tclievelde\core\api\ApiResponseFactory;
use Tclievelde\customPostTypes\matches\matchPost;
use Tclievelde\Tclievelde;
use WP_REST_Request;
use WP_REST_Response;

/**
 * Class Get_Tractors_By_Specs
 * @package Tclievelde\API\endpoints
 */
class GetMatchesById
{
    /**
     * @return void
     */
    public function register(): void
    {
        /** Registers API endpoint to retrieve the suggested search results. */
        add_action('rest_api_init', [ $this, 'bindRoute' ]);
    }

    /**
     * @return void
     */
    public function bindRoute(): void
    {
        register_rest_route('search', 'matches-by-id', [
                'methods'  => 'GET',
                'callback' => [ $this, 'handle_request' ],
                'permission_callback' => '__return_true',
            ]);
    }

    /**
     * @param WP_REST_Request $request
     *
     * @return WP_REST_Response
     */
    public function handleRequest(WP_REST_Request $request) : WP_REST_Response
    {
        $id_list = $request->get_param('id_list');
        $id_list = explode(',', $id_list);

        $matches = Tclievelde::getMatches()->fromIDs($id_list);
        $non_entitled_properties = ['general_image', 'motor_max_hp', 'motor_brand_type', 'general2_weight_kg', 'name'];
        $attributes = $non_entitled_properties;

        /* @var $match matchPost */
        foreach ($matches as $match) {
            $match->loadAttributes($attributes);

            $rest_objects['matches'][] = $match->toRestObject();
        }


        return ( new ApiResponseFactory() )
            ->setData($rest_objects)
            ->getResponse();
    }
}
