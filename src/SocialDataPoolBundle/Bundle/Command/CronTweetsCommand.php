<?php

namespace SocialDataPoolBundle\Bundle\Command;

use SocialDataPool\Application\Service\Tweet\LookForTweetRequest;
use SocialDataPool\Application\Service\Uvinum\GetSpecificDoRequest;
use SocialDataPool\Application\Service\Uvinum\GetTopSellingProductRequest;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class CronTweetsCommand extends ContainerAwareCommand
{
    const SEARCH_ID_TOP_SELLING = 1;
    const SEARCH_ID_DO          = 2;

    protected function configure()
    {
        $this
            ->setName('twitter:search-all')
            ->setDescription('Look for new tweets by the top selling products and DOs in Uvinum and save them in Redis.')
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
        $uvinum_use_case = $this->getContainer()->get('get_top_selling_product_use_case');
        $use_case        = $this->getContainer()->get('look_for_tweet_use_case');

        $wine_type = $input->getArgument('wine-type');

        $output->writeln('Wine type specified: ' . $wine_type);

        for ($wine_type_index = 0; $wine_type_index < 20; $wine_type_index++)
        {
            $uvinum_request                 = new GetTopSellingProductRequest($wine_type, $wine_type_index);
            $specific_product_to_search_for = $uvinum_use_case->__invoke($uvinum_request);

            $output->writeln('Searching tweets containing the product name: ' . $specific_product_to_search_for['name']
            );

            $twitter_request = $this->buildTwitterRequestForTopSelling($specific_product_to_search_for['name'],
                $specific_product_to_search_for['product_id'],
                10
            );
            $use_case->__invoke($twitter_request);
        }

        $uvinum_use_case = $this->getContainer()->get('get_specific_do_use_case');

        for ($wine_type_index = 0; $wine_type_index < 13; $wine_type_index++)
        {
            $uvinum_request            = new GetSpecificDoRequest($wine_type_index);
            $specific_do_to_search_for = $uvinum_use_case->__invoke($uvinum_request);

            $output->writeln('Searching tweets containing the DO: ' . $specific_do_to_search_for);

            $twitter_request = $this->buildTwitterRequestForDO($specific_do_to_search_for,
                $uvinum_request->offset(),
                10
            );
            $use_case->__invoke($twitter_request);
        }
        $output->writeln('Tweets Processed');
    }

    private function buildTwitterRequestForTopSelling(
        $query,
        $search_related_content,
        $number_of_tweets = '1',
        $language = 'es'
    )
    {
        return new LookForTweetRequest($query,
            self::SEARCH_ID_TOP_SELLING,
            $search_related_content,
            $number_of_tweets,
            $language
        );
    }

    private function buildTwitterRequestForDO(
        $query,
        $search_related_content,
        $number_of_tweets
    )
    {
        return new LookForTweetRequest($query, self::SEARCH_ID_DO, $search_related_content, $number_of_tweets);
    }
}
