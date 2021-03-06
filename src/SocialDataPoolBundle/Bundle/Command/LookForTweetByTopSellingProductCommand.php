<?php

namespace SocialDataPoolBundle\Bundle\Command;

use SocialDataPool\Application\Service\Tweet\LookForTweet;
use SocialDataPool\Application\Service\Tweet\LookForTweetRequest;
use SocialDataPool\Application\Service\Uvinum\GetTopSellingProduct;
use SocialDataPool\Application\Service\Uvinum\GetTopSellingProductRequest;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class LookForTweetByTopSellingProductCommand extends ContainerAwareCommand
{
    const SEARCH_ID = 1;

    protected function configure()
    {
        $this
            ->setName('twitter:search-top-selling')
            ->setDescription('Look for new tweets by the top selling products in Uvinum and save them in Redis.')
            ->addArgument(
                'wine-type',
                InputArgument::REQUIRED,
                'Wine Type to look for products'
            )
            ->addArgument(
                'offset',
                InputArgument::OPTIONAL,
                'Specific top selling product'
            )
            ->addArgument(
                'number_of_tweets',
                InputArgument::OPTIONAL,
                'The number of tweets to provide'
            );
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    )
    {
        $uvinum_use_case = $this->getContainer()->get('get_top_selling_product_use_case');
        $use_case        = $this->getContainer()->get('look_for_tweet_use_case');

        $wine_type        = $input->getArgument('wine-type');
        $offset           = $input->getArgument('offset');
        $number_of_tweets = $input->getArgument('number_of_tweets');

        $uvinum_request                 = new GetTopSellingProductRequest($wine_type, $offset);
        $specific_product_to_search_for = $uvinum_use_case->__invoke($uvinum_request);

        $output->writeln('Searching tweets that contains: ' . $specific_product_to_search_for['name']);

        $twitter_request = $this->buildTwitterRequest($specific_product_to_search_for['name'], $specific_product_to_search_for['product_id'], $number_of_tweets);
        $use_case->__invoke($twitter_request);

        $output->writeln('Tweets Processed');
    }

    private function buildTwitterRequest(
        $query,
        $search_related_content,
        $number_of_tweets = '1',
        $language = 'es'
    )
    {
        return new LookForTweetRequest($query, self::SEARCH_ID, $search_related_content, $number_of_tweets, $language);
    }
}
