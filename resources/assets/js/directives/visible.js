/**
 * Bind visible / invisible style into an element.
 *
 * @param el
 * @param binding
 */
export default (el, binding) => {
  el.style.visibility = binding.value ? 'visible' : 'hidden'
}
