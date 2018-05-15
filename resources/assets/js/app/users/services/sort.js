// dependencies.
import { flow, filter, orderBy } from 'lodash/fp'

import { matchesAny } from '@/helpers/text/match'

// Sort users based on filters and sort settings.
export default (users, { filters }, { column, direction }) => {
  // do filter & sort
  return flow(
    filter((user) => matchesAny(user, filters)), // multiple field search
    orderBy([column], [direction]) // sort / order by a given column in a given direction
  )(users) // apply users as data on the flow.
}
