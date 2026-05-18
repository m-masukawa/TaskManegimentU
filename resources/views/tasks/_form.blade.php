<div style="margin-bottom: 15px;">
    <label for="title" style="display: block; font-weight: bold;">タスク名 <span style="color: red;">*</span></label>
    <input type="text" name="title" id="title" value="{{ old('title', $task->title ?? '') }}" style="width: 100%; padding: 8px;">
</div>

<div style="margin-bottom: 15px;">
    <label for="description" style="display: block; font-weight: bold;">詳細説明</label>
    <textarea name="description" id="description" rows="4" style="width: 100%; padding: 8px;">{{ old('description', $task->description ?? '') }}</textarea>
</div>

<div style="margin-bottom: 15px;">
    <label for="status" style="display: block; font-weight: bold;">ステータス <span style="color: red;">*</span></label>
    <select name="status" id="status" style="width: 100%; padding: 8px;">
        @php $currentStatus = old('status', $task->status ?? 'todo'); @endphp
        <option value="todo" {{ $currentStatus == 'todo' ? 'selected' : '' }}>未対応 (To Do)</option>
        <option value="doing" {{ $currentStatus == 'doing' ? 'selected' : '' }}>処理中 (Doing)</option>
        <option value="done" {{ $currentStatus == 'done' ? 'selected' : '' }}>完了 (Done)</option>
    </select>
</div>

<div style="margin-bottom: 20px;">
    <label for="due_date" style="display: block; font-weight: bold;">期限日</label>
    <input type="date" name="due_date" id="due_date" value="{{ old('due_date', $task->due_date ?? '') }}" style="padding: 8px;">
</div>