<?php

use Phinx\Seed\AbstractSeed;

class PostSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $this->table('posts')->truncate();
        $faker = Faker\Factory::create('FR_fr');

        $images = [
            "https://lh3.googleusercontent.com/aqD5-pxnnFFdbMhYLSpmvqN1fOj0A_LXNv1Wm3DfQ_dAvt9L08gt0xr2rpjcVR4NS7AxCwHgbnKYMfN9EeC0QsRvSzhfV5csvcd0WRFNh_tThkBZuHtD25L_4kCNmkoZYEW4_2FZin5H1JOPRsBX5Ttbixg_qufS8miRI6gPNli87CT5yQxP6jhmTxTuJXxZz6ZPV1NIMn2Jn-IVanzQANvWvcQCPPuTxblzeVnCQxwowH_IS6do03Aiv7CfV0vgPmlmhn166hM5y1Rrg625HIgJNbVgdBKhxWE-FWUIzP3I1jpns2l9IdTDLgDUwz5mhN--Reox2_Q-TBKw1v4kO7oeGLpymdDaJZfu1nY5jymFp2JZRlEPzoMlrEwgNAyrhcgdeIK31azG7LEnSopWTfk18tfE42sT0HZjeTWUqFC5e7YbIGHQBNrSbb7WJg0-dD8kbsAd-XagMDLoOEm0__cSjZil0JZVJzQv7dKAd_FIUEP7TS2VSyiF_1VWu0ORzKZEMD_g7N180vKlKRcbq-VguLpaeLdzPr2aBK9jrmURCdfyfv1oUxwExgsjrRCzigN9N_c5-msRghDifjkty_Gggg84Cl2tqw7nX89WUXAl2_-cZEn_EB9f23tAhcP0tiv5CZh6pYGjJmudVqId_23DWgSktldIETZWIZoEqAFapAHFQVxcPrDw=w480-h270-no",
            "https://lh3.googleusercontent.com/O6Pit4hTwWFm5y0ke5Bmr__VHH8MreySo039zy_1VLXRvgJImmLD_OTIm7xmnD42ob9gZVjBPECaSCgQyKjsxJJioRViIam5WV_VApUoxHnTfI5FL3sEKWGTdFXNadn17p5K3cpErukqeOLp7tEGI5GlYQzpT3wshwOEG7W0Nr2OO7HFQdNS6BsYljVc3FZXrcOrTqiv6vreBq2S_UPaF_fauLGc0HLQPIGNf3ds7wYaU-e6YMcyMuiN0_UeWqr-deXkGNnIlr1HNRDAkWsQH9T-7n-SyYaMxZcFLxto1nEpR5ZxLghusqWNlgv2tvs_-K5ALTrlO7H5-ahy0eQL2clrvrx1U_Py9eYK3qJu0yGx2OxPPES6GVF60qh1uNREMC4QRAu9UPqoKi0w_Xz7b75aAHj6ENPD19wY8yEkxJys0-3a0sYMCx4aw3gGpG63DtLan431UXnGPPwe0eFxRzjcnl-XjBRLnZPmQKPkBHkMiLor_cI_gDnljnd2HdmCywB1uqaV7A49BNLVaJA5IVe709heL1P_UGLU-3RKaR8-25__DGMg5Urc1IvXR36ct3KBq-Zb3G17SQY2n4qMYNSp-kznEddwszB1JkzPCa411ONpoY_LHzttCTO0WKcz4TJdecR0IQvFxu17_VQKXe0nA0Y5EuJ7DENdafAnvemK6QNwQo9lxyZX=w457-h257-no",
            "https://lh3.googleusercontent.com/aqD5-pxnnFFdbMhYLSpmvqN1fOj0A_LXNv1Wm3DfQ_dAvt9L08gt0xr2rpjcVR4NS7AxCwHgbnKYMfN9EeC0QsRvSzhfV5csvcd0WRFNh_tThkBZuHtD25L_4kCNmkoZYEW4_2FZin5H1JOPRsBX5Ttbixg_qufS8miRI6gPNli87CT5yQxP6jhmTxTuJXxZz6ZPV1NIMn2Jn-IVanzQANvWvcQCPPuTxblzeVnCQxwowH_IS6do03Aiv7CfV0vgPmlmhn166hM5y1Rrg625HIgJNbVgdBKhxWE-FWUIzP3I1jpns2l9IdTDLgDUwz5mhN--Reox2_Q-TBKw1v4kO7oeGLpymdDaJZfu1nY5jymFp2JZRlEPzoMlrEwgNAyrhcgdeIK31azG7LEnSopWTfk18tfE42sT0HZjeTWUqFC5e7YbIGHQBNrSbb7WJg0-dD8kbsAd-XagMDLoOEm0__cSjZil0JZVJzQv7dKAd_FIUEP7TS2VSyiF_1VWu0ORzKZEMD_g7N180vKlKRcbq-VguLpaeLdzPr2aBK9jrmURCdfyfv1oUxwExgsjrRCzigN9N_c5-msRghDifjkty_Gggg84Cl2tqw7nX89WUXAl2_-cZEn_EB9f23tAhcP0tiv5CZh6pYGjJmudVqId_23DWgSktldIETZWIZoEqAFapAHFQVxcPrDw=w457-h257-no",
            "https://lh3.googleusercontent.com/md7IObihUSYOUlSp3eUd8Vajs8ZStAEYjSwhXQPpw4C8QjThDH_ve305yRFuMr-laRK9aQLlMAFnrKFFkdtH94Hh7288psF5Lg4WONz_iEHBTBdAORy78YDYN4mnr0oPJj42vCKU5fC2fROluN6Cqz6QwGhf8slU6PY0Kr4tJCHUoHjh98zaBwT8OHw91NV7nssjcn3GLLFL0CXwEDzDqZOR4fMKeylOzbHrx6v0HMriRObQ4dkE48vTcR6ERkutRzCv7ez5GUzAv6x8coqRmPmJrxZMf_AM9gqoOcluxNGl4O56MuX4JuA3A43AZRig1bSrnihPYnW_EixbbckLbtNRO_K1m1b98kAJUJpvVeL2XuWdNcSQYkik56_fVqKTeC7Vih8fipY5n1GaKyED5c85BjF4KMCJpoKmoqFtegl7wVeOjvArODF0Oxt-wx-CrKEk4J2pP422-1Ge4ybera5_wm8Qjrt7ilx6dCsa3Nv4ssO0lmFTxe9r_ZDPxnA39jQLWx3ga80PNXI8XVrnlMVpD0BL0VdLGDME5-XPS_hEsMupxlMuzKK04vKJvd4_c6v9mgPLcVPDoUrJDwHdtuSvRErc9Dx-D2_yHqj9BWLwps1Tyn8glVd7Y9h37zAxz5N4MvuClTqxHCKZI0qq3xJQC4B-3BqgwcKtXCphxFjqHx8PfZ_HFLu6=w457-h257-no",
            "https://lh3.googleusercontent.com/wDtjLrudTdq5NtIiUgGUUcsklPkLnSAtPgKRJppTG0XhOxdR7vwxBh0jjvuE44W68zDWBCJN-Z7sAuCI2HUHCXQA7DPYod-m1cKkbgwCmuEMPytOEwLMhIG6RVgLYQX7SM6ONFmrAAN3yIZnSz3mx3t87fgAORNHOyA4JdqPPU_Fsi1Y4kuvSZA2LMvHKlGOWkZcVmPhTKxk4iTKpQszXhBG5s8D_gzq607cjF-wkwD5s2iLJ9lHO_A-LoGyh5hqPTm5RY7yfrjXql_N32QekLV_yrjxycxLoJfpwFwveUjyQfXL_a7cx9YZwOXxmC5N9W7jvFr2HoWJQGo_zNI6AtFPLi0eRfv32jSlt_TQL-Il9h-VWjy9u9nAt45XHu6RuYanE04WX0U0Fz_zxKjbRHrDqoWzGyyCDy4trN-H5j4eTMe9_zalswU-Pk_2MwMYOGBaOYA-PtHcB-Hf9gDCSNLWhoEQqJgQGRUbnECOR4EE73siebYnEWJXND4L-7PGJ81kJxKPRAD4COwlU5btnFP2M0FYr3qDikkczTyXxZUzwUkF52HIIgJNyCDDflA8IoiUtnGV6FtyNwtjenq0VXkQsIivSWorM5GCOTyQDtZDJfC6iDZ3jsBZf4PZ6mxhkTZt5xIPixeGB-twoc1iW-rv28y1lrYvVkuMcz6phU9NnFOdCX5AYXco=w457-h257-no",
            "https://lh3.googleusercontent.com/c076zmCNlx_54IE6o5kC3uQ6JySA-Mgwl91Pg2PPHZ6oJkq2_uTimilbDccNDAwu57fLjeKTn9anx977jCCWLRm6ZNFkj7irFRNLBKYIFMR239ibCkW5VC1HoBpSrvFEbg4RjUObeK4_ZGFleHIVoWV2D4UFqU2WXDSty_XboM0vQRZ8JQMBc_OnpKiLERY_NdCQlGK5TNPBdjK2oPyqfQ5Xr1coRHuUceTnhgEumEUn_Tswn7FHZwmpnHgXy65_fsuj8SFIFc_G_seCyntlPgO9dx06tAZdVYCJESxgdGlqhe0zDebcO7HOa4k0JX8makqD0N7eLcAgOV9Z1Ko9OBft4HN4W-t2eLYSWCyclyc6uQGFJbbRilCwnYW_-8fmefCVormD5jOTwYz0Mwz0NaP_pNRsjEkwszwsVewqxrYAgMWu0uIt0ht1PYrSaohD7TaS0d-WAB-oCbX49Did1VSFC-NRqjJYV0qOr1E3eL_hUEg9QLgPYBErAEX1nexXk6MwEo4PbiASyqUIJmm5JhcoGO4HGaSSeG7ZGgC3TLmLeWnoRzNlRp3gu3Tn2GhoYHvYW26pYMRbAMj782xaGNzrXWoSoBllMadNU0xSVrCDQyJyEQGc3YHgudPoxC6yfmCJO1YEovjfUbTane4VaxLlvKN4JF3RifSZVE_xnvWfL9o-ipl4bg44=w457-h257-no",
            "https://lh3.googleusercontent.com/j4fTfjWBqtqHBlj22B5bGZxjf-wPVaHsH-yDq0eI4n6fL86DFwtu0cSSqYaILwgf7MonZHIJ9TWLXq5nK9WtiBJKnuW5WfoS2IeWE7OFkoj_DHpwCVUMWwa7ggh6Bx9cxiu4VORA2KYtljagPWS-IvJg06i98Vo4hE-Kikhy-10O-6Qy5rmDn4QS_YzP-K2mFGMlqjE9ePJkq_fNiaCavKf0wDSM9AfvpXskxVkzSQFde57uX2VDutD9ba_PmvfQ1C4ce7CSVkx_gPEvnmv6YI5o85t-4DNy_wsYOiAAZYOhdG1Mk2Q877KSHb61K4e0zb6Nyd4RC-XIxyRz7YOAuKtQdaVX7tPIQWyZbsCt3ocuUOA2cjyElYYp4EnOnZO3OiLqOPFjwY9_gViAd6dQfPUDL7Wb_C5CuSngs1COEuBj2lwmLe4rwN3xn7OoMwgeHFEXqKb2233xV1CAOJ4WwZUtgoIROfQoRUqCIsIkizh_Sk_bNNQ7YwTDZKNmLDr9ssqgBcD7H29GkB6hGuce8VTUP8uprypAV3sIFYInc1HGtCwSXvXcft3q2Z_LWNVWTyw-PmeyQHfoSlirabCyOxM9f7BBA13Vko-vMCRUyuFa-LFlICqzVsK60N74zTrcMgYP13zfzIch9IwgDh4oPtt2BWOq7WeR0zQf6GN2KdN8I87qZLMCyDjWaw=w457-h257-no",
            "https://lh3.googleusercontent.com/vT6Om6BzCvhkvDM0Lb2eWCPs8xj6aywJW77pt4HL_trCL3bhv9SwT7Te1rCXI69Cumr5BrdOt7HvknWo1BlZ9FnwHIgGxU6gAw4M53AAjMvgJP6oDqM86zV3u_koKBZlAK6Yn_k2AwnLDl7KYSIyO5z3Ab9VtSs5D_2gyGpLnjl8cTnjr9LdMMLwDJepT4V2BmEG9K4xMTQuAmqrzdIq3V4BFGI_lyFNt35vRH4GuG9ZlB_diI3elmeUrhIRLrWqCBICWnVohyj-mMQH-xLa5WNLqsQ597FU4Ic1WtFjN-OGf4jzVeg_tGFkHsA7YFbOIJiZ3NxAO3l-ecRjy1nYw6u9OR-MokQaSTeTVqeGCDd_GyQ8135tIm1b-qiIr2LUjLGVnb-0v9lraI5lUGveEAYvaWrB7atf__t8RFEhUNXXcyYqFNP_ZchwZJ-Ud4F2dp6rHVNy8zvJ2AZo5KwJz6DHsVA1JJ-OdOS00eeLOQcyBnkKpwP9tk7-6JW9q6ib5CGK1O_qtossryGCR7wFXs7HrVtpRv4CCvDcCd9kAhklxGKBm-dvsLLpe5ShGxOtWI22gzetLu5zTPPuMJLOCi0q_43yO9ZCys4DxfWslxE7iAF0aHAgh6jvzPLH3_eoXytd01NRz2b1wK4fZp8CeMeP6mEbkVn0mNhIg-nRMnIo8v56VTeq4FKMDw=w457-h257-no",
            "https://lh3.googleusercontent.com/rbHWVWgyItEQUKWf1iEQW-hdTdrx9ICmuGvLkHsXdh_oJYttLVjCEn3vkt17IqkHhx_QyZqtbks0Th9HHeeSOXBdoK9AzxNTc8P5PjnGRspMj93j3E39u7d-gdjHzmXKD6Z61IaNIsKWvczvLLUw-RMfAo2B4OztOxmRn8HS3XzcYBw_OBNOTOfpZrrNXJCXYUQjocHpndPl_sNgX5UU9DGCTAPYc9HRYdAMIEhe0FxoCaiwjV41XkftZXixrpJ4oXW_Kur3brVUyv0U4m3_qQsrGPEHosVPMJ-MhziLpw7p6oic6UZ-SwZSgHa3vvDk09m0DBTg2enz2HJE-wInHC1Xtdp_ftZgw_Q_IiwzFRSgBAdhxpiu4rTacW4KrofrGlk2tTxxXdd78hhW4VmrcRo8804qTLdgSWpn7vHlDHhO1cPW7_dy6mZmcUQNLeJKTyNlYA7ypwvVfdzwkrBubtz9cuQaSs0mjbS7c0HAwSFxWnJJAaqTieXyy2Y2ZaMuXCV-6KwRC5OMYGAmWcFjiuvl3hFkkmSFzoGOrCNH98oH2T2YpYTlTsVNhlMjlV-Kt6gxCQ0wkm4Vii14AQMsjmNaTVH5DTWDoPp29znrkw-oQVSP4Sgzf-uCOgqFLByOw1AikcSbe92PWnAodL48a4FfsL0gavr_XijDfYKvEYXndQTeeayMYmIP=w457-h257-no",
            "https://static.wixstatic.com/media/4d79d8_77c4ba5887c94e528d9085e45b8cb00f~mv2_d_4128_3096_s_4_2.jpg/v1/fill/w_672,h_504,al_c,q_80,usm_0.66_1.00_0.01/4d79d8_77c4ba5887c94e528d9085e45b8cb00f~mv2_d_4128_3096_s_4_2.jpg",
            "https://static.wixstatic.com/media/4d79d8_98989385f6ce474b810f8e2d532514f9~mv2_d_4032_2268_s_2.jpg/v1/fill/w_672,h_378,al_c,q_80,usm_0.66_1.00_0.01/4d79d8_98989385f6ce474b810f8e2d532514f9~mv2_d_4032_2268_s_2.jpg",
            "https://static.wixstatic.com/media/4d79d8_6a26622eb6a544b4ab644208b9107316~mv2_d_4032_2268_s_2.jpg/v1/fill/w_630,h_354,al_c,q_80,usm_0.66_1.00_0.01/4d79d8_6a26622eb6a544b4ab644208b9107316~mv2_d_4032_2268_s_2.jpg",
            "https://static.wixstatic.com/media/4d79d8_e0a7ead3f2ce4f91b39c86dabccc0a0c~mv2_d_4032_2268_s_2.jpg/v1/fill/w_1452,h_817,al_c,q_90,usm_0.66_1.00_0.01/4d79d8_e0a7ead3f2ce4f91b39c86dabccc0a0c~mv2_d_4032_2268_s_2.jpg",
            "https://static.wixstatic.com/media/4d79d8_dda3fd87d3014b1dad42d15f30cdce6d~mv2_d_4032_2268_s_2.jpg/v1/fill/w_672,h_378,al_c,q_80,usm_0.66_1.00_0.01/4d79d8_dda3fd87d3014b1dad42d15f30cdce6d~mv2_d_4032_2268_s_2.jpg"
        ];
        $markdown = "## hello world

Sunt bromiumes anhelare clemens, festus aususes.Primus impositio saepe convertams adelphis est.This pattern has only been attacked by a final sensor.
Sunt bromiumes anhelare clemens, festus aususes.Primus impositio saepe convertams adelphis est.This pattern has only been attacked by a final sensor.
Sunt bromiumes anhelare clemens, festus aususes.Primus impositio saepe convertams adelphis est.This pattern has only been attacked by a final sensor.

- Ferox, flavum onuss aliquando anhelare de alter, bi-color urbs.
- Unprepared fears loves most thoughts.
- Why does the crewmate meet?
- Captains are the cosmonauts of the virtual resistance.

Sunt bromiumes anhelare clemens, festus aususes.Primus impositio saepe convertams adelphis est.This pattern has only been attacked by a final sensor.
Sunt bromiumes anhelare clemens, festus aususes.Primus impositio saepe convertams adelphis est.This pattern has only been attacked by a final sensor.
Sunt bromiumes anhelare clemens, festus aususes.Primus impositio saepe convertams adelphis est.This pattern has only been attacked by a final sensor.

## helo world

Sunt bromiumes anhelare clemens, festus aususes.Primus impositio saepe convertams adelphis est.This pattern has only been attacked by a final sensor.
Sunt bromiumes anhelare clemens, festus aususes.Primus impositio saepe convertams adelphis est.

### This pattern has only been attacked by a final sensor.

Sunt bromiumes anhelare clemens, festus aususes.Primus impositio saepe convertams adelphis est.This pattern has only been attacked by a final sensor.
Sunt bromiumes anhelare clemens, festus aususes.Primus impositio saepe convertams adelphis est.This pattern has only been attacked by a final sensor.
Sunt bromiumes anhelare clemens, festus aususes.Primus impositio saepe convertams adelphis est.This pattern has only been attacked by a final sensor.";
        //posts
        $posts = [];

        $identifiers = [];
        for ($i = 0; $i < 10; $i++) {
            $identifiers[] = uniqid();
        }

        $identifier = 0;
        $locale = false;
        for ($i = 0; $i < 20; $i++) {
            if ($locale) {
                $locale = 'fr';
            } else {
                $locale = 'en';
            }
            $title = $faker->sentence();
            $posts[] = [
                'id' => uniqid(),
                'identifier' => $identifiers[$identifier],
                'locale' => $locale,
                'title' => $title,
                'slug' => str_slug($title),
                'description' => $faker->text(190),
                'image' => $faker->randomElement($images),
                'content' => $markdown,
                'created_at' => $faker->dateTimeThisYear->format('Y-m-d H:i:s'),
                'updated_at' => $faker->dateTimeThisYear->format('Y-m-d H:i:s')
            ];
            if ($i % 2) {
                $locale = false;
                $identifier++;
            }
        }
        $this->insert('posts', $posts);
    }
}
