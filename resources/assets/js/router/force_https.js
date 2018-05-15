import { get } from 'lodash'

export default () => {
  const env = get(process.env, 'NODE_ENV')
  if (env !== 'production') {
    return
  }

  if (window.location.protocol !== 'https:') {
    // window.location.href = window.location.href.replace('http:', 'https:')
  }
}
