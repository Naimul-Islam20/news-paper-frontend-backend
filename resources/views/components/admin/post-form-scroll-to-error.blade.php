@props([
    'formId' => 'post-create-form',
    'requireImage' => true,
])

@php
    $serverErrorKey = null;
    if ($errors->any()) {
        $priority = [
            'title',
            'category_ids',
            'image',
            'existing_image',
            'description',
            'reporter_id',
            'sub_title_points',
        ];
        foreach ($priority as $key) {
            if ($errors->has($key)) {
                $serverErrorKey = $key;
                break;
            }
        }
        if (! $serverErrorKey) {
            foreach ($errors->keys() as $key) {
                if (str_starts_with($key, 'sub_title_points')) {
                    $serverErrorKey = 'sub_title_points';
                    break;
                }
                if (str_starts_with($key, 'category_ids')) {
                    $serverErrorKey = 'category_ids';
                    break;
                }
            }
        }
        if (! $serverErrorKey) {
            $serverErrorKey = $errors->keys()[0] ?? null;
        }
    }
@endphp

@push('scripts')
<script>
(function () {
    const formId = @json($formId);
    const requireImage = @json($requireImage);
    const serverErrorKey = @json($serverErrorKey);

    const fieldMap = {
        title: '#post-title-field',
        category_ids: '#post-category-field',
        image: '#post-image-field',
        existing_image: '#post-image-field',
        description: '#post-description-field',
        reporter_id: '#post-reporter-field',
        sub_title_points: '#sub-title-points-field',
    };

    function resolveSelector(errorKey) {
        if (!errorKey) {
            return null;
        }
        if (fieldMap[errorKey]) {
            return fieldMap[errorKey];
        }
        if (errorKey.indexOf('sub_title_points') === 0) {
            return fieldMap.sub_title_points;
        }
        if (errorKey.indexOf('category_ids') === 0) {
            return fieldMap.category_ids;
        }
        return null;
    }

    function scrollToSelector(selector) {
        const el = document.querySelector(selector);
        if (!el) {
            return;
        }

        el.scrollIntoView({ behavior: 'smooth', block: 'center' });

        if (selector === '#post-description-field' && typeof CKEDITOR !== 'undefined' && CKEDITOR.instances.editor) {
            CKEDITOR.instances.editor.focus();
            return;
        }

        const focusable = el.querySelector('input:not([type="hidden"]), select, textarea, button, [tabindex]:not([tabindex="-1"])');
        if (focusable && typeof focusable.focus === 'function') {
            focusable.focus({ preventScroll: true });
        }

        el.classList.add('ring-2', 'ring-rose-400', 'rounded-lg');
        window.setTimeout(function () {
            el.classList.remove('ring-2', 'ring-rose-400', 'rounded-lg');
        }, 2800);
    }

    function stripHtml(html) {
        const tmp = document.createElement('div');
        tmp.innerHTML = html || '';
        return (tmp.textContent || tmp.innerText || '').trim();
    }

    function hasFeaturedImage(form) {
        const fileInput = form.querySelector('#mainImageInput');
        const existingImage = form.querySelector('#existingImagePath');
        const preview = form.querySelector('#mainImagePreview');

        if (fileInput && fileInput.files && fileInput.files.length > 0) {
            return true;
        }
        if (existingImage && existingImage.value) {
            return true;
        }
        if (preview && !preview.classList.contains('hidden') && preview.getAttribute('src')) {
            return true;
        }
        return false;
    }

    function validatePostForm(form) {
        const issues = [];

        const title = form.querySelector('#post_title');
        if (title && !title.value.trim()) {
            issues.push({ selector: fieldMap.title, message: 'শিরোনাম অবশ্যই দিতে হবে।' });
        }

        if (!form.querySelector('[name="category_ids[]"]:checked')) {
            issues.push({ selector: fieldMap.category_ids, message: 'ক্যাটাগরি বা সাব-ক্যাটাগরি নির্বাচন করুন।' });
        }

        if (requireImage && !hasFeaturedImage(form)) {
            issues.push({ selector: fieldMap.image, message: 'ছবি আপলোড করুন বা মিডিয়া থেকে বেছে নিন।' });
        }

        let description = '';
        if (typeof CKEDITOR !== 'undefined' && CKEDITOR.instances.editor) {
            description = stripHtml(CKEDITOR.instances.editor.getData());
        } else {
            const editor = form.querySelector('#editor');
            description = editor ? stripHtml(editor.value) : '';
        }
        if (!description) {
            issues.push({ selector: fieldMap.description, message: 'বিবরণ লিখুন।' });
        }

        const reporter = form.querySelector('[name="reporter_id"]');
        if (reporter && !reporter.value) {
            issues.push({ selector: fieldMap.reporter_id, message: 'রিপোর্টার নির্বাচন করুন।' });
        }

        return issues;
    }

    function showClientError(container, message) {
        if (!container) {
            return;
        }
        container.querySelectorAll('.js-client-validation-error').forEach(function (el) {
            el.remove();
        });
        const p = document.createElement('p');
        p.className = 'js-client-validation-error mt-1 text-xs text-rose-500';
        p.textContent = message;
        container.appendChild(p);
    }

    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById(formId);
        if (!form) {
            return;
        }

        if (serverErrorKey) {
            window.setTimeout(function () {
                scrollToSelector(resolveSelector(serverErrorKey));
            }, 350);
        }

        form.addEventListener('submit', function (event) {
            form.querySelectorAll('.js-client-validation-error').forEach(function (el) {
                el.remove();
            });

            const issues = validatePostForm(form);
            if (issues.length > 0) {
                event.preventDefault();
                event.stopPropagation();
                const first = issues[0];
                scrollToSelector(first.selector);
                showClientError(document.querySelector(first.selector), first.message);
                return;
            }

            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
                const invalid = form.querySelector(':invalid');
                if (invalid) {
                    invalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    invalid.focus({ preventScroll: true });
                } else {
                    form.reportValidity();
                }
            }
        }, true);
    });
})();
</script>
@endpush
