const exchange = (arr, a, b) => {
    temp = arr[a];
    arr[a] = arr[b];
    arr[b] = temp;
}

const selectionSort = (arr, cmp, reverse = false) => 
{
    for (i = 0; i < arr.length; i++)
    {
        minor = i;
        for (j = i + 1; j < arr.length; j++)
        {
            if (cmp (arr[minor], arr[j]) > 0)
                minor = j;
        }

        exchange(arr, i, minor);
    }

    if (reverse)
        arr.reverse();
}

const bucketSort = (array, chave = undefined, reverse = false, bucketSize = 5) => {
    if (array.length === 0 || array.length === 1)
        return array;
      
    type_sort = {
        'number': () => {
            minValue = array.reduce((a, b) => {
                return (a < b) ? a : b;
            });
            
            maxValue = array.reduce((a, b) => {
                return (a >= b) ? a : b;
            });   

            // Initializing buckets
            var bucketCount = Math.floor((maxValue - minValue) / bucketSize) + 1;
            var allBuckets = new Array(bucketCount);
            
            for (var i = 0; i < allBuckets.length; i++) {
                allBuckets[i] = [];
            }
            
            // Pushing values to buckets
            array.forEach((currentVal) => {
                allBuckets[Math.floor((currentVal - minValue) / bucketSize)].push(currentVal);
            });

            // Sorting buckets
            array.length = 0;
            
            allBuckets.forEach((bucket) => {
                selectionSort(bucket, (a, b) => (a - b));
                bucket.forEach((element) => {
                    array.push(element);
                });
            });

            return array;
        },      
        'object': () => {
            minValue = array.reduce((a, b) => {
                return (a[chave] < b[chave]) ? a : b;
            })[chave];

            maxValue = array.reduce((a, b) => {
                return (a[chave] >= b[chave]) ? a : b;
            })[chave]; 
            
            // Initializing buckets
            var bucketCount = Math.floor((maxValue - minValue) / bucketSize) + 1;
            var allBuckets = new Array(bucketCount);
            
            for (var i = 0; i < allBuckets.length; i++) {
                allBuckets[i] = [];
            }
            
            // Pushing values to buckets
            array.forEach((currentVal) => {
                allBuckets[Math.floor((currentVal[chave] - minValue) / bucketSize)].push(currentVal);
            });

            // Sorting buckets
            array.length = 0;
            
            allBuckets.forEach((bucket) => {
                selectionSort(bucket, (a, b) => (a[chave] - b[chave]));
                bucket.forEach((element) => {
                    array.push(element);
                });
            });

            return array;
        }
    };

    temp = type_sort[typeof array[0]];
    array = temp ();
    
    return (reverse) ? array.reverse() : array;
}

const sort = selectionSort;