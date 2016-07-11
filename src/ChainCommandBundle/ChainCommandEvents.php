<?php

namespace ChainCommandBundle;


/**
 * Class ChainCommandEvents
 *
 * Describe all events for ChainCommand bundle.
 *
 * @package ChainCommandBundle
 */
final class ChainCommandEvents
{
    /**
     * Event before chain executed.
     */
    const CHAIN_START = 'chain_command.chain.start';

    /**
     * Event before master command has been executed.
     */
    const CHAIN_COMMAND_MASTER_EXECUTE = 'chain_command.chain.command_master.execute';

    /**
     * Event before chain commands has been executed.
     */
    const CHAIN_COMMAND_CHAINS_EXECUTE = 'chain_command.chain.command_chains.execute';

    /**
     * Event after command has been executed.
     */
    const CHAIN_COMMAND_EXECUTED = 'chain_command.chain.command.executed';

    /**
     * Event after chain has finished.
     */
    const CHAIN_FINISH = 'chain_command.chain.finish';

    /**
     * Event on chain command execution out of parent scope.
     */
    const CHAIN_COMMAND_ERROR = 'chain_command.chain.command.error';
}
