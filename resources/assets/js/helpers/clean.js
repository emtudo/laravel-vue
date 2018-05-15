import { isEmpty } from 'lodash'

const patternOnlyNumber = /[^0-9]+/g

export const replace = (value, pattern, replacement = '') => {
  if (value === null) {
    return
  }

  return value.replace(pattern, replacement)
}
export const onlyNumbers = value => replace(value, patternOnlyNumber)

export const pickAndClean = (item, fields = [], initialData = {}, pattern = patternOnlyNumber) => {
  if (isEmpty(item)) {
    return item
  }

  return fields.reduce((acc, key) => {
    if (!isEmpty(item[key])) {
      return Object.assign({}, acc, {
        // está definindo um valor a parti da chave {key}
        [key]: replace(item[key], pattern)
      })
    }

    return acc
  }, initialData)
}

export const cleanProps = (item, fields = [], pattern = patternOnlyNumber) => {
  return pickAndClean(item, fields, item, pattern)
}
