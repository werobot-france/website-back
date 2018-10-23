<?php

namespace App\Controllers;

use App\Models\Message;
use App\ReCaptcha;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Response;
use Validator\Validator;

class PhotosController extends Controller
{
    public function photos(ServerRequestInterface $request, Response $response)
    {
        $validator = new Validator($request->getQueryParams());
        $validator->notEmpty('limit');
        $validator->integer('limit');
        if (!$validator->isValid()) {
            return $response->withJson([
                'success' => false,
                'errors' => $validator->getErrors()
            ], 400);
        }
        $limit = $validator->getValue('limit');
        $photos = [
            ['description' => 'Pius adelphiss ducunt ad equiso.', 'url' => 'https://static.wixstatic.com/media/4d79d8_77c4ba5887c94e528d9085e45b8cb00f~mv2_d_4128_3096_s_4_2.jpg/v1/fill/w_672,h_504,al_c,q_80,usm_0.66_1.00_0.01/4d79d8_77c4ba5887c94e528d9085e45b8cb00f~mv2_d_4128_3096_s_4_2.jpg'],
            ['description' => 'Unconditional reincarnations handles most issues.', 'url' => 'https://static.wixstatic.com/media/4d79d8_98989385f6ce474b810f8e2d532514f9~mv2_d_4032_2268_s_2.jpg/v1/fill/w_672,h_378,al_c,q_80,usm_0.66_1.00_0.01/4d79d8_98989385f6ce474b810f8e2d532514f9~mv2_d_4032_2268_s_2.jpg'],
            ['description' => 'The collective is oddly boldly.', 'url' => 'https://static.wixstatic.com/media/4d79d8_6a26622eb6a544b4ab644208b9107316~mv2_d_4032_2268_s_2.jpg/v1/fill/w_630,h_354,al_c,q_80,usm_0.66_1.00_0.01/4d79d8_6a26622eb6a544b4ab644208b9107316~mv2_d_4032_2268_s_2.jpg'],
            ['description' => 'Varius abactors ducunt ad epos.', 'url' => 'https://static.wixstatic.com/media/4d79d8_b6e91c6fcacc4190a43e6c73c0a6ff67~mv2_d_4032_2268_s_2.jpg/v1/fill/w_672,h_378,al_c,q_80,usm_0.66_1.00_0.01/4d79d8_b6e91c6fcacc4190a43e6c73c0a6ff67~mv2_d_4032_2268_s_2.jpg'],
            ['description' => 'Wonderful solitudes yearns most happinesses.', 'url' => 'https://lh3.googleusercontent.com/c076zmCNlx_54IE6o5kC3uQ6JySA-Mgwl91Pg2PPHZ6oJkq2_uTimilbDccNDAwu57fLjeKTn9anx977jCCWLRm6ZNFkj7irFRNLBKYIFMR239ibCkW5VC1HoBpSrvFEbg4RjUObeK4_ZGFleHIVoWV2D4UFqU2WXDSty_XboM0vQRZ8JQMBc_OnpKiLERY_NdCQlGK5TNPBdjK2oPyqfQ5Xr1coRHuUceTnhgEumEUn_Tswn7FHZwmpnHgXy65_fsuj8SFIFc_G_seCyntlPgO9dx06tAZdVYCJESxgdGlqhe0zDebcO7HOa4k0JX8makqD0N7eLcAgOV9Z1Ko9OBft4HN4W-t2eLYSWCyclyc6uQGFJbbRilCwnYW_-8fmefCVormD5jOTwYz0Mwz0NaP_pNRsjEkwszwsVewqxrYAgMWu0uIt0ht1PYrSaohD7TaS0d-WAB-oCbX49Did1VSFC-NRqjJYV0qOr1E3eL_hUEg9QLgPYBErAEX1nexXk6MwEo4PbiASyqUIJmm5JhcoGO4HGaSSeG7ZGgC3TLmLeWnoRzNlRp3gu3Tn2GhoYHvYW26pYMRbAMj782xaGNzrXWoSoBllMadNU0xSVrCDQyJyEQGc3YHgudPoxC6yfmCJO1YEovjfUbTane4VaxLlvKN4JF3RifSZVE_xnvWfL9o-ipl4bg44=w457-h257-no'],
            ['description' => 'Lentils combines greatly with aged cabbage.', 'url' => 'https://static.wixstatic.com/media/4d79d8_98989385f6ce474b810f8e2d532514f9~mv2_d_4032_2268_s_2.jpg/v1/fill/w_672,h_378,al_c,q_80,usm_0.66_1.00_0.01/4d79d8_98989385f6ce474b810f8e2d532514f9~mv2_d_4032_2268_s_2.jpg']
        ];
        return $response->withJson([
            'success' => true,
            'data' => [
                'photos' => array_slice($photos, 0, $limit)
            ]
        ]);
    }
}