# encording: utf-8

puts "あなたの身長を教えてください(cmで入力)"

sintyou = gets.chomp.to_f

puts "あなたの体重を教えてください(kgで入力)"

taizyu = gets.chomp.to_i

# 入力された身長をmに換算
sintyoum = sintyou /100

# BMIの計算をして変数に入れる
bmi = ( taizyu / ( sintyoum * sintyoum ) ).round(2)

# BMIの数値に合った言葉を変数に入れる
if bmi < 18.5
  tekisei = "低体重"
elsif bmi >= 18.5 && bmi < 25
  tekisei = "普通体重"
else bmi >= 25
  tekisei = "肥満"
end

# 適正体重の計算
tekisei2 = ((sintyoum * sintyoum) * 22).round(2)

# 出力
puts "-------------------------------------"
puts "あなたのBMIは、#{bmi}です。"
puts "あなたは、#{tekisei}です。"
puts "あなたの適正体重は、#{tekisei2}kgです。"