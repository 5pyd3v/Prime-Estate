<?php
declare(strict_types=1);

function admin_agents_index(): void
{
    Auth::require();
    $items = DB::connection()->query('SELECT * FROM agents ORDER BY sort_order, name')->fetchAll();
    view('admin/agents/index', ['title' => 'Agents', 'active' => 'agents', 'items' => $items]);
}

function agent_payload(): array
{
    return [
        'name' => trim((string) input('name', '')),
        'photo_media_id' => (int) input('photo_media_id') ?: null,
        'designation' => trim((string) input('designation', '')) ?: null,
        'phone' => trim((string) input('phone', '')) ?: null,
        'whatsapp' => trim((string) input('whatsapp', '')) ?: null,
        'email' => trim((string) input('email', '')) ?: null,
        'bio' => trim((string) input('bio', '')) ?: null,
        'facebook_url' => trim((string) input('facebook_url', '')) ?: null,
        'instagram_url' => trim((string) input('instagram_url', '')) ?: null,
        'linkedin_url' => trim((string) input('linkedin_url', '')) ?: null,
        'twitter_url' => trim((string) input('twitter_url', '')) ?: null,
        'sort_order' => (int) input('sort_order', 0),
        'is_active' => input('is_active') ? 1 : 0,
    ];
}

function admin_agents_create_show(): void
{
    Auth::require();
    view('admin/agents/form', ['title' => 'Add Agent', 'active' => 'agents', 'agent' => null]);
}

function admin_agents_store(): void
{
    Auth::require();
    Csrf::verifyRequest();
    $data = agent_payload();
    if ($data['name'] === '') {
        flash('error', 'Name is required.');
        redirect('/admin/agents/create');
    }
    $data['slug'] = unique_slug(fn ($slug) => (bool) Agent::findBy('slug', $slug), $data['name']);
    Agent::insert($data);
    flash('success', 'Agent added.');
    redirect('/admin/agents');
}

function admin_agents_edit_show(int $id): void
{
    Auth::require();
    $agent = Agent::find($id);
    if (!$agent) {
        abort(404);
    }
    view('admin/agents/form', ['title' => 'Edit Agent', 'active' => 'agents', 'agent' => $agent]);
}

function admin_agents_update(int $id): void
{
    Auth::require();
    Csrf::verifyRequest();
    $data = agent_payload();
    if ($data['name'] === '') {
        flash('error', 'Name is required.');
        redirect("/admin/agents/{$id}/edit");
    }
    $data['slug'] = slug_for_update('agents', $id, $data['name'], Agent::find($id));
    Agent::update($id, $data);
    flash('success', 'Agent updated.');
    redirect('/admin/agents');
}

function admin_agents_delete(int $id): void
{
    Auth::require();
    Csrf::verifyRequest();
    Agent::delete($id);
    flash('success', 'Agent deleted.');
    redirect('/admin/agents');
}
