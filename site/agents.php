<?php
declare(strict_types=1);

function site_agents_index(): void
{
    view('pages/agents', [
        'title' => 'Our Agents',
        'description' => 'Meet the Prime Estates team of local property experts across Pakistan.',
        'heroPage' => false,
        'agents' => Agent::active(),
    ]);
}

function site_agent_detail(array $params): void
{
    $agent = Agent::bySlug($params['slug']);
    if (!$agent || !$agent['is_active']) {
        abort(404);
    }

    view('pages/agent-detail', [
        'title' => $agent['name'] . ' — Property Agent',
        'description' => $agent['bio'] ? truncate($agent['bio'], 200) : '',
        'heroPage' => false,
        'agent' => $agent,
        'properties' => Property::byAgent((int) $agent['id']),
    ]);
}
