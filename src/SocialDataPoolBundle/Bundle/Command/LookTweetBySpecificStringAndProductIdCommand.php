<?php

namespace SocialDataPoolBundle\Bundle\Command;

use SocialDataPool\Application\Service\Tweet\LookForTweetRequest;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class LookTweetBySpecificStringAndProductIdCommand extends ContainerAwareCommand
{
    const SEARCH_ID = 1;

    protected function configure()
    {
        $this
            ->setName('twitter:search-string-product')
            ->setDescription('Look for new tweets by its name, associate a product id and save them in Redis.')
            ->addArgument(
                'query',
                InputArgument::REQUIRED,
                'The string you want to search for'
            )
            ->addArgument(
                'product_id',
                InputArgument::REQUIRED,
                'Specific product id from Uvinum'
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
        $use_case = $this->getContainer()->get('look_for_tweet_use_case');

        $query            = $input->getArgument('query');
        $product_id       = $input->getArgument('product_id');
        $number_of_tweets = $input->getArgument('number_of_tweets');

        $output->writeln('Searching tweets that contains: ' . $query);

        $twitter_request = $this->buildTwitterRequest($query,
            $product_id,
            $number_of_tweets
        );
        $use_case->__invoke($twitter_request);

        $output->writeln('Tweets Processed');
    }

    private function buildTwitterRequest(
        $query,
        $search_related_content,
        $number_of_tweets = '10',
        $language = 'es'
    )
    {
        return new LookForTweetRequest($query, self::SEARCH_ID, $search_related_content, $number_of_tweets, $language);
    }
}
