#!/usr/bin/env node
'use strict';

/**
 * AIOX Default Mode — UserPromptSubmit hook.
 *
 * Injects a standing directive so EVERY change request in this project is
 * handled in Synkra AIOX mode (right agent persona + Story-Driven workflow +
 * quality gates) WITHOUT the user needing to type an @agent activation.
 *
 * Contract:
 *   - Reads the hook JSON from stdin (ignored — directive is static).
 *   - Writes UserPromptSubmit additionalContext to stdout.
 *   - NEVER blocks the prompt: any error => silent exit 0.
 */

const DIRECTIVE = [
  '<aiox-default-mode>',
  'This project runs Synkra AIOX as the DEFAULT operating mode. The user should',
  'NOT need to type @agent to get AIOX behavior — infer and apply it automatically.',
  '',
  'For ANY request that changes the system (add / implement / build / fix /',
  'refactor / migrate / configure / test) — even with no @ mention:',
  '  1. Silently act AS the right AIOX agent, and state which one at the top:',
  '     @dev code · @architect design · @qa tests/quality · @po|@sm stories ·',
  '     @devops git+CI (exclusive) · @analyst research · @ux-design-expert UX ·',
  '     @data-engineer DB · @aiox-master coordination.',
  '  2. Follow AIOX Story-Driven Development and the rules in .claude/rules/',
  '     (story-lifecycle, workflow-execution, agent-authority).',
  '  3. Respect the L1-L4 boundary: never modify .aiox-core/core/ (L1) or the',
  '     framework templates (L2). Project work lives in app/, resources/, routes/,',
  '     docs/stories/, etc.',
  '  4. Quality-First gates for THIS stack (Laravel 11 + Livewire, PHP):',
  '     lint => ./vendor/bin/pint ; tests => php artisan test. (NOT npm.)',
  '',
  'For pure questions / discussion (no change requested), answer normally — no',
  'agent ceremony required.',
  '</aiox-default-mode>',
].join('\n');

let done = false;

function emit() {
  if (done) return;
  done = true;
  try {
    process.stdout.write(
      JSON.stringify({
        hookSpecificOutput: {
          hookEventName: 'UserPromptSubmit',
          additionalContext: DIRECTIVE,
        },
      }),
    );
  } catch (_err) {
    /* never throw from a hook */
  }
}

// Drain stdin (the hook payload) then emit. Guarded so we emit exactly once.
try {
  process.stdin.setEncoding('utf8');
  process.stdin.on('data', () => {});
  process.stdin.on('end', emit);
  process.stdin.on('error', emit);
} catch (_err) {
  emit();
}

// Safety net: if stdin never closes, still emit and exit within the timeout.
setTimeout(() => {
  emit();
  process.exit(0);
}, 2000).unref();
