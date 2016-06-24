<?php

namespace SocialDataPoolBundle\Bundle\Command;

use SocialDataPool\Application\Service\Instagram\LookForInstagramPostRequest;
use SocialDataPool\Application\Service\Uvinum\GetSpecificDoRequest;
use SocialDataPool\Application\Service\Uvinum\GetTopSellingProductRequest;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class CronPostsCommand extends ContainerAwareCommand
{
    const SEARCH_ID_TOP_SELLING = 1;
    const SEARCH_ID_DO          = 2;

    protected function configure()
    {
        $this
            ->setName('instagram:search-all')
            ->setDescription('Look for new instagram posts by the top selling products and DOs in Uvinum and save them in Redis.'
            )
            ->addArgument(
                'wine-type',
                InputArgument::REQUIRED,
                'Wine Type to look for products'
            );
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    )
    {
        $uvinum_use_case    = $this->getContainer()->get('get_top_selling_product_use_case');
        $instagram_use_case = $this->getContainer()->get('look_for_instagram_post_use_case');
        $instagram_client   = $this->getContainer()->get('instagram_api_client');
        $token              = $this->getContainer()->getParameter('instagram_token');
        $instagram_client->setAccessToken($token);

        $wine_type = $input->getArgument('wine-type');

        for ($wine_type_index = 0; $wine_type_index < 20; $wine_type_index++)
        {
            $uvinum_request                         = new GetTopSellingProductRequest($wine_type, $wine_type_index);
            $specific_product_to_search_for         = $uvinum_use_case->__invoke($uvinum_request);
            $specific_product_to_search_for['name'] = str_replace(' ', '', $specific_product_to_search_for['name']);

            $output->writeln('Searching Instagram posts with product name tag: ' . $specific_product_to_search_for['name']);

            $request = new LookForInstagramPostRequest($specific_product_to_search_for['name'],
                self::SEARCH_ID_TOP_SELLING,
                $specific_product_to_search_for['product_id']
            );
            $instagram_use_case->__invoke($request);
        }

        $uvinum_use_case = $this->getContainer()->get('get_specific_do_use_case');

        for ($wine_type_index = 0; $wine_type_index < 13; $wine_type_index++)
        {
            $uvinum_request            = new GetSpecificDoRequest($wine_type_index);
            $specific_do_to_search_for = $uvinum_use_case->__invoke($uvinum_request);
            $specific_do_to_search_for = str_replace(' ', '', $specific_do_to_search_for);

            $output->writeln('Searching Instagram posts with DO tag: ' . $specific_do_to_search_for);

            $request = new LookForInstagramPostRequest($specific_do_to_search_for,
                self::SEARCH_ID_DO,
                $uvinum_request->offset()
            );
            $instagram_use_case->__invoke($request);
        }

        $output->writeln('Instagram Posts Processed');
    }
}
