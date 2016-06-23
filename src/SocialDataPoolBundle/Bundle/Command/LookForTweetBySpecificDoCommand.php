<?php

namespace SocialDataPoolBundle\Bundle\Command;

use SocialDataPool\Application\Service\Tweet\LookForTweet;
use SocialDataPool\Application\Service\Tweet\LookForTweetRequest;
use SocialDataPool\Application\Service\Uvinum\GetSpecificDo;
use SocialDataPool\Application\Service\Uvinum\GetSpecificDoRequest;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class LookForTweetBySpecificDoCommand extends ContainerAwareCommand
{
    const SEARCH_ID = 2;

    protected function configure()
    {
        $this
            ->setName('twitter:search-specific-do')
            ->setDescription('Look for new tweets by an specific DO and save them in Redis.')
            ->addArgument(
                'offset',
                InputArgument::REQUIRED,
                'Specific DO to search for'
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
        $uvinum_use_case = $this->getContainer()->get('get_specific_do_use_case');
        $use_case        = $this->getContainer()->get('look_for_tweet_use_case');

        $offset           = $input->getArgument('offset');
        $number_of_tweets = $input->getArgument('number_of_tweets');

        $uvinum_request            = new GetSpecificDoRequest($offset);
        $specific_do_to_search_for = $uvinum_use_case->__invoke($uvinum_request);

        $output->writeln('Searching tweets that contains: ' . $specific_do_to_search_for);

        $twitter_request = $this->buildTwitterRequest($specific_do_to_search_for,
            $uvinum_request->offset(),
            $number_of_tweets
        );
        $use_case->__invoke($twitter_request);

        $output->writeln('Tweets Processed');
    }

    private function buildTwitterRequest(
        $query,
        $search_related_content,
        $number_of_tweets
    )
    {
        if (null === $number_of_tweets)
        {
            return new LookForTweetRequest($query, self::SEARCH_ID, $search_related_content);
        }

        return new LookForTweetRequest($query, self::SEARCH_ID, $search_related_content, $number_of_tweets);
    }
}
