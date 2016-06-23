<?php

namespace SocialDataPoolBundle\Bundle\Command;

use SocialDataPool\Application\Service\Instagram\LookForInstagramPost;
use SocialDataPool\Application\Service\Instagram\LookForInstagramPostRequest;
use SocialDataPool\Application\Service\Uvinum\GetTopSellingProduct;
use SocialDataPool\Application\Service\Uvinum\GetTopSellingProductRequest;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class LookForPostByTopSellingProductCommand extends ContainerAwareCommand
{
    const SEARCH_ID = 1;

    protected function configure()
    {
        $this
            ->setName('instagram:search-top-selling')
            ->setDescription('Look for new instagram posts by the top selling products in Uvinum and save them in Redis.'
            )
            ->addArgument(
                'wine-type',
                InputArgument::REQUIRED,
                'Wine Type to look for products'
            )
            ->addArgument(
                'offset',
                InputArgument::OPTIONAL,
                'Specific top selling product'
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
        $offset    = $input->getArgument('offset');

        $uvinum_request                         = new GetTopSellingProductRequest($wine_type, $offset);
        $specific_product_to_search_for         = $uvinum_use_case->__invoke($uvinum_request);
        $specific_product_to_search_for['name'] = str_replace(' ', '', $specific_product_to_search_for['name']);

        $output->writeln('Searching Instagram posts with tag: ' . $specific_product_to_search_for['name']);

        $request = new LookForInstagramPostRequest($specific_product_to_search_for['name'], self::SEARCH_ID,
            $specific_product_to_search_for['product_id']
        );
        $instagram_use_case->__invoke($request);

        $output->writeln('Instagram Posts Processed');
    }
}
