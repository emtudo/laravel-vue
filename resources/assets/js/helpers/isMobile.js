export default () => {
  try {
    return ('ontouchstart' in window)
  } catch (e) {
    return false
  }
}
