from collections import defaultdict
import codecs, json

"""
This script transforms the DSAmembers1881-1911 tsv into
a stacked bar chart, using Google Charts to visualize
the result. The script is meant as an example of the ways
we can parse the Dante data and visualize the results :)

The expected data output is:

  [
    ['Genre', 'Fantasy & Sci Fi', 'Romance', 'Mystery/Crime', 'General',
     'Western', 'Literature', { role: 'annotation' } ],
    ['2010', 10, 24, 20, 32, 18, 5, ''],
    ['2020', 16, 22, 23, 30, 16, 9, ''],
    ['2030', 28, 19, 29, 30, 12, 13, '']
  ]

where the first array contains factor labels (e.g. "M", "F"),
and each subsequent array contains a year value followed by
the number of obsevations for each factor level
"""

# this is a little interesting: Here we initialize
# a special 
year_to_gender_count = defaultdict(lambda: defaultdict(int))

# open the specified file in "Read" mode (which means
# we won't be able to write to the file) using the utf8 encoding
with codecs.open("./DSAmembers1881-1911.tsv", "r", "utf8") as f:
  
  # read the opened file
  f = f.read()

  # remove windows carriage returns from the file
  f = f.replace("\r", "")

  # split the opened file into a list, splitting on each
  # newline character. Each member of the rows object
  # will now be a single row from the spreadsheet
  rows = f.split("\n")

  # the first row of the spreadsheet contains headers,
  # so let's remove that
  rows = rows[1:]

  # examine each row within the rows object
  for r in rows:

    # take the current value of row and split it into a list,
    # splitting on tab characters. Each member of split_row
    # will now be a single cell within the current row
    split_row = r.split("\t")
    
    # identify the data in each cell for this row:
    # the 0th cell of the row contains the individual's name
    name = split_row[0]

    # the 1st (using 0-based counting) cell of the row
    # contains the location of the individual
    location = split_row[1]

    # the 2nd cell of the row contains the person's entrance
    # into the dante society
    start = split_row[2]

    # the 3rd cell of the row contains the person's exit
    # from the dante society
    end = split_row[3]

    # the 4th cell contains the person's gender {M,F}
    gender = split_row[4]

    # now we want to determine the list of years this person
    # was a member of the dante society. To do so, we can
    # subtract the year the person left the society from
    # the year the person joined the society (e.g. 1881 - 1880)
    # then add one (as anyone who was a member from only
    # 1880-1880 was still a member for one year)
    # NB: end and start are currently strings, so one must
    # coerce them into integers before doing math with them
    years_as_member = (int(end) - int(start)) + 1

    # now for each year the person was a member of the society,
    # let's increment the count of females by one if the person
    # was a female, else let's increment the count of males by one
    for year in xrange(years_as_member):
      # right now the year object is a value from 0 to the
      # number of years this person was a member. In other words,
      # year indicates 0 if this is the person's 1st year of membership,
      # 1 if this is the person's 2nd year of membership, and so on.
      # To convert this value to a year value such as 1881, we need to add
      # the starting year
      
      # NB: As above, we need to convert our string objects into
      # integers before we can do math with them
      year_value = int(start) + int(year)
      year_to_gender_count[year_value][gender] += 1

  # print the contents of the year_to_gender_count
  # object to the terminal so we can inspect its
  # form
  print year_to_gender_count

  ###
  # Prepare json for the visualization
  ###

  # first let's initialize the output json as
  # an empty list
  output_json = []


  # then let's add the first member to that list.
  # We can see in the desired output format
  # above that this first member should be an array
  # that contains a label, each category of our visualization,
  # and an Object = {"role": "annotation"}
  output_json.append( ["Gender", "F", "M", { "role": "annotation" }])

  # then let's iterate over each year key in the
  # year_to_gender_count object
  for year in year_to_gender_count.iterkeys():

    # parse out the number of female members
    # for that year
    female_count = year_to_gender_count[year]["F"]
    male_count = year_to_gender_count[year]["M"]

    # now add a new row to the output json with 3 members:
    # the given year, the female count, then the male count
    # nb: year must be a string object, not an integer
    output_json.append([str(year), female_count, male_count, ""])

# now just write the json to disk
with open("dante_members_over_time.json", "w") as out:
  json.dump(output_json, out)
