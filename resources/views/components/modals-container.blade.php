
@can('update', $idea)
  <livewire:edit-idea :idea="$idea"/>
@endcan
@can('delete', $idea)
  <livewire:delete-idea :idea="$idea"/>
@endcan
@auth
  <livewire:mark-idea-as-spam :idea="$idea"/>
  <livewire:mark-idea-as-not-spam :idea="$idea"/>
@endauth
@auth
  <livewire:edit-comment :idea="$idea"/>
@endauth
@auth
    <livewire:delete-comment/>
@endauth
