<?php

namespace SocialDataPoolBundle\Bundle\Command;

use SocialDataPool\Application\Service\Instagram\LookForInstagramPost;
use SocialDataPool\Application\Service\Instagram\LookForInstagramPostRequest;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class LookForPostCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('instagram:search')
            ->setDescription('Look for new instagram posts and save them in Redis.')
            ->addArgument(
                'query',
                InputArgument::REQUIRED,
                'The string you want to search for'
            );
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    )
    {
        /** @var LookForInstagramPost $use_case */
        $use_case = $this->getContainer()->get('look_for_instagram_post_use_case');

        $query    = $input->getArgument('query');

        $instagram_client = $this->getContainer()->get('instagram_api_client');
        $token = $this->getContainer()->getParameter('instagram_token');
        $instagram_client->setAccessToken($token);
        $request = new LookForInstagramPostRequest($query);

        $use_case->__invoke($request);

        $output->writeln('Instagram Posts Processed');
    }
}
