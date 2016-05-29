<?php

namespace SocialDataPoolBundle\Bundle\Command;

use SocialDataPool\Application\Service\Tweet\LookForTweet;
use SocialDataPool\Application\Service\Tweet\LookForTweetRequest;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class LookForTweetCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('twitter:search')
            ->setDescription('Look for new tweets and save them in Redis.')
            ->addArgument(
                'query',
                InputArgument::REQUIRED,
                'The string you want to search for'
            )
            ->addArgument(
                'language',
                InputArgument::OPTIONAL,
                'The language to look for the tweets'
            )
            ->addArgument(
                'count',
                InputArgument::OPTIONAL,
                'The number of tweets to provide'
            );
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    )
    {
        /** @var LookForTweet $use_case */
        $use_case = $this->getContainer()->get('look_for_tweet_use_case');

        $query    = $input->getArgument('query');
        $language = $input->getArgument('language');
        $count    = $input->getArgument('count');

        $request = $this->buildRequest($query, $language, $count);

        $use_case->__invoke($request);

        $output->writeln('Tweets Processed');
    }

    private function buildRequest(
        $query,
        $language,
        $count
    )
    {
        if (null === $language)
        {
            return new LookForTweetRequest($query);
        }
        else
        {
            if (null === $count)
            {
                return new LookForTweetRequest($query, $language);
            }

            return new LookForTweetRequest($query, $language, $count);
        }
    }
}
