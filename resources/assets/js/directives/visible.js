import { isExecute } from './helpers'

/**
 * Bind display style into an element (block/none).
 *
 * @param el
 * @param binding
 */
export default (el, binding) => {
  const value = isExecute(el, binding)

  const visible = value ? 'visible' : 'hidden'

  el.style.visibility = visible
}
