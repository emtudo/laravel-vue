import ucfirst from '@/helpers/ucfirst'

export const datasetValue = (el, binding) => {
  const name = 'v' + ucfirst(binding.name)
  const value = el.dataset[name]
  if (!value) {
    return null
  }

  return value
}

export const isExecute = (el, binding) => {
  const value = datasetValue(el, binding)
  if (!value) {
    return true
  }

  return JSON.parse(value || false)
}

export const run = function (el, binding) {
  if (isExecute(el, binding)) {
    const name = binding.name

    el[name]()
  }
}
